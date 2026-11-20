<?php

namespace App\Livewire\Workspaces\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Builder extends Component
{
    private const LIMIT = 10;

    private const TYPES = [
        'text' => ['Kısa metin', 'Aa'],
        'textarea' => ['Uzun metin', '¶'],
        'email' => ['E-posta', '@'],
        'number' => ['Sayı', '#'],
        'select' => ['Açılır liste', '▾'],
        'radio' => ['Tek seçim', '○'],
        'checkbox' => ['Çoklu seçim', '□'],
        'date' => ['Tarih', '12'],
    ];

    private const CHOICE_TYPES = ['select', 'radio', 'checkbox'];

    #[Locked]
    public array $order = [1, 2, 3];

    #[Locked]
    public array $fieldTypes = [1 => 'text', 2 => 'email', 3 => 'radio'];

    #[Locked]
    public int $nextId = 4;

    public array $settings = [
        1 => ['label' => 'Ad soyad', 'placeholder' => 'Deniz Yılmaz', 'options' => '', 'required' => true],
        2 => ['label' => 'E-posta', 'placeholder' => 'deniz@ornek.com', 'options' => '', 'required' => true],
        3 => ['label' => 'Hangi oturuma katılacaksın?', 'placeholder' => '', 'options' => "Sabah\nÖğleden sonra\nİkisi de", 'required' => true],
    ];

    #[Locked]
    public string $notice = 'Örnek form · Bu sayfadaki düzenlemeler geçici.';

    public function addField(string $type): void
    {
        if (! isset(self::TYPES[$type]) || count($this->order) >= self::LIMIT) {
            return;
        }

        $id = $this->nextId++;
        $this->order[] = $id;
        $this->fieldTypes[$id] = $type;
        $this->settings[$id] = [
            'label' => self::TYPES[$type][0],
            'placeholder' => '',
            'options' => in_array($type, self::CHOICE_TYPES, true) ? "Seçenek 1\nSeçenek 2" : '',
            'required' => false,
        ];
        $this->notice = self::TYPES[$type][0].' alanı eklendi.';
    }

    public function moveField(int $id, int $direction): void
    {
        $index = array_search($id, $this->order, true);
        if ($index === false || ! in_array($direction, [-1, 1], true)) {
            return;
        }

        $next = $index + $direction;
        if (! isset($this->order[$next])) {
            return;
        }

        [$this->order[$index], $this->order[$next]] = [$this->order[$next], $this->order[$index]];
        $this->notice = 'Alan '.($next + 1).'. sıraya taşındı.';
    }

    public function removeField(int $id): void
    {
        $index = array_search($id, $this->order, true);
        if ($index === false) {
            return;
        }

        array_splice($this->order, $index, 1);
        unset($this->fieldTypes[$id], $this->settings[$id]);
        $this->notice = 'Alan kaldırıldı.';
    }

    public function updatingSettings(mixed $value, ?string $key): void
    {
        [$id, $setting] = array_pad(explode('.', $key ?? '', 2), 2, '');
        $validated = isset($this->fieldTypes[$id]) && match ($setting) {
            'required' => is_bool($value),
            'label', 'placeholder' => is_string($value) && mb_strlen($value) <= 150,
            'options' => is_string($value) && mb_strlen($value) <= 1000,
            default => false,
        };

        if (! $validated) {
            throw ValidationException::withMessages(['settings.'.$key => 'Alan ayarını kontrol et.']);
        }
    }

    public function render(): View
    {
        return view('livewire.workspaces.forms.builder', [
            'types' => self::TYPES,
            'choiceTypes' => self::CHOICE_TYPES,
            'limit' => self::LIMIT,
        ])
            ->extends('formcraft.builder')
            ->section('page');
    }
}
