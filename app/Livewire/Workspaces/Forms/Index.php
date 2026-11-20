<?php

namespace App\Livewire\Workspaces\Forms;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Index extends Component
{
    private const TITLES = [
        'published' => 'Aralık Buluşmasına kayıt',
        'draft' => 'Stajyer başvurusu',
        'closed' => 'Yaz okulu memnuniyet anketi',
    ];

    public ?string $search = '';

    #[Locked]
    public string $status = 'all';

    public function filter(string $status): void
    {
        if ($status === 'all' || isset(self::TITLES[$status])) {
            $this->status = $status;
        }
    }

    public function render(): View
    {
        $query = mb_strtolower(str_replace('I', 'ı', str_replace('İ', 'i', trim($this->search ?? ''))));
        $visible = [];

        foreach (self::TITLES as $status => $title) {
            $title = mb_strtolower(str_replace('I', 'ı', str_replace('İ', 'i', $title)));
            if (($this->status === 'all' || $this->status === $status) && str_contains($title, $query)) {
                $visible[] = $status;
            }
        }

        $user = auth()->user();
        $forms = $user->workspaces()->with(['forms' => function ($query) use ($visible) {
            $query->whereIn('status', $visible);
        }])->get()->pluck('forms')->flatten();

        return view('livewire.workspaces.forms.index', ['visible' => $visible, 'status' => $this->status, 'user' => $user, 'forms' => $forms])
            ->extends('formcraft.forms')
            ->section('page');
    }
}
