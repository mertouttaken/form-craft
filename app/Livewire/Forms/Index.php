<?php

namespace App\Livewire\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Index extends Component
{
    public ?string $name = '';

    public ?string $email = '';

    public ?string $session = '';

    public ?string $attendees = '2';

    public ?string $arrivalDate = '2026-12-10';

    public ?string $note = '';

    public function submit(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:254'],
            'session' => ['required', Rule::in(['morning', 'afternoon', 'both'])],
            'attendees' => ['nullable', 'integer', 'between:1,4'],
            'arrivalDate' => ['nullable', 'date_format:Y-m-d'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'Ad soyad alanını doldur.',
            'email.required' => 'E-posta adresini yaz.',
            'email.email' => 'Geçerli bir e-posta adresi yaz.',
            'session.required' => 'Bir oturum seç.',
            'session.in' => 'Listeden bir oturum seç.',
            'attendees.between' => '1 ile 4 arasında bir sayı yaz.',
        ]);

        $sessionLabel = match ($validated['session']) {
            'morning' => 'Sabah',
            'afternoon' => 'Öğleden sonra',
            'both' => 'İkisi de',
        };

        $arrivalDate = $validated['arrivalDate'] ?? null;
        session()->put('formcraft.preview.aralik_submission', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'session' => $sessionLabel,
            'attendees' => $validated['attendees'] ?? null,
            'arrivalDate' => $arrivalDate ? implode('.', array_reverse(explode('-', $arrivalDate))) : null,
            'submittedAt' => now('Europe/Istanbul')->format('d.m.Y · H:i'),
        ]);

        $this->redirectRoute('formcraft.preview.thanks');
    }

    public function render(): View
    {
        return view('livewire.forms.index')
            ->extends('formcraft.public-form')
            ->section('page');
    }
}
