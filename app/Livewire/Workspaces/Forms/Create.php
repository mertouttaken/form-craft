<?php

namespace App\Livewire\Workspaces\Forms;

use App\Models\Forms;
use App\Models\Workspaces;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Create extends Component
{
    #[Locked]
    public string $workspace = '';

    public string $title = '';

    public string $description = '';

    public function mount(string $workspace): void
    {
        $this->workspace = $workspace;
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'title.required' => 'Formun bir adı olmalı.',
            'title.max' => 'Ad en fazla 120 karakter olabilir.',
            'description.max' => 'Açıklama en fazla 500 karakter olabilir.',
        ];
    }

    /**
     * Save the form as a draft in this workspace, then go on to add its fields.
     */
    public function save(): void
    {
        $this->validate();

        if ($this->slug === '') {
            $this->addError('title', 'Ad en az bir harf ya da rakam içermeli.');

            return;
        }

        $workspace = Workspaces::where('slug', $this->workspace)->firstOrFail();

        $form = Forms::create([
            'workspace_id' => $workspace->id,
            'title' => trim($this->title),
            'description' => trim($this->description) ?: null,
            'public_slug' => $this->slug,
            'status' => 'draft',
            'settings' => json_encode([
                'success_message' => 'Teşekkürler, yanıtın alındı.',
                'redirect_url' => null,
                'notify_email' => null,
                'allow_multiple' => false,
            ], JSON_UNESCAPED_UNICODE),
            'submissions_count' => 0,
        ]);

        $this->redirectRoute('formcraft.preview.fields', [
            'workspace' => $workspace->slug,
            'form' => $form->public_slug,
        ]);
    }

    /**
     * The public link built from the title: "Gezi Planı" becomes "gezi_plani".
     * When that link is taken, a number is added: gezi_plani_2, gezi_plani_3.
     */
    #[Computed]
    public function slug(): string
    {
        $base = Str::slug($this->title, '_', 'tr');

        if ($base === '') {
            return '';
        }

        $slug = $base;
        $suffix = 2;

        while (Forms::where('public_slug', $slug)->exists()) {
            $slug = "{$base}_{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    public function render()
    {
        return view('livewire.workspaces.forms.create')
            ->extends('formcraft.form-create')
            ->section('page');
    }
}
