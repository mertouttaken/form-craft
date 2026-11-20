<?php

namespace App\Livewire\Workspaces\Forms\Fields;

use App\Livewire\Concerns\LoadsWorkspaceForm;
use App\Models\Fields;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Create extends Component
{
    use LoadsWorkspaceForm;

    /**
     * Type => [label, hint].
     */
    public const TYPES = [
        'text' => ['Metin', 'Tek satır'],
        'textarea' => ['Uzun metin', 'Çok satır'],
        'email' => ['E-posta', 'Biçim denetlenir'],
        'number' => ['Sayı', 'Min ve max'],
        'select' => ['Seçim', 'Açılır liste'],
        'radio' => ['Tek seçim', 'Radyo düğmesi'],
        'checkbox' => ['Çoklu seçim', 'Onay kutuları'],
        'date' => ['Tarih', 'Gün, ay, yıl'],
    ];

    public const CHOICE_TYPES = ['select', 'radio', 'checkbox'];

    /**
     * Free workspaces can have at most this many fields per form.
     */
    public const FREE_FIELD_LIMIT = 10;

    public string $type = 'text';

    public string $label = '';

    public string $placeholder = '';

    public string $helpText = '';

    public bool $isRequired = true;

    /** @var list<string> */
    public array $options = ['', ''];

    public string $min = '';

    public string $max = '';

    public string $pattern = '';

    public function mount(string $workspace, string $form): void
    {
        $this->loadForm($workspace, $form);
    }

    public function addOption(): void
    {
        $this->options[] = '';
    }

    public function removeOption(int $index): void
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function isChoice(): bool
    {
        return in_array($this->type, self::CHOICE_TYPES, true);
    }

    public function limitReached(): bool
    {
        return $this->workspaceModel->plan === 'free'
            && $this->formModel->fields()->count() >= self::FREE_FIELD_LIMIT;
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'type' => ['required', Rule::in(array_keys(self::TYPES))],
            'label' => ['required', 'string', 'max:150'],
            'placeholder' => ['nullable', 'string', 'max:150'],
            'helpText' => ['nullable', 'string', 'max:255'],
            'isRequired' => ['boolean'],
            'options' => [Rule::requiredIf($this->isChoice()), 'array'],
            'options.*' => ['nullable', 'string', 'max:100'],
            'min' => ['nullable', 'integer'],
            'max' => ['nullable', 'integer', 'gte:min'],
            'pattern' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'label.required' => 'Etiket zorunlu. Yanıtlayan hata mesajlarında bu adı görecek.',
            'label.max' => 'Etiket en fazla 150 karakter olabilir.',
            'options.*.max' => 'Bir seçenek en fazla 100 karakter olabilir.',
            'min.integer' => 'Tam sayı yaz.',
            'max.integer' => 'Tam sayı yaz.',
            'max.gte' => 'En çok, en azdan küçük olamaz.',
        ];
    }

    public function save(): void
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function (Validator $validator) {
                if ($this->isChoice() && count($this->filledOptions()) < 2) {
                    $validator->errors()->add('options', 'En az iki seçenek yaz.');
                }

                if ($this->pattern !== '' && @preg_match($this->pattern, '') === false) {
                    $validator->errors()->add('pattern', 'Desen geçerli bir regex değil. Örn. /^[0-9]{11}$/');
                }
            });
        })->validate();

        if ($this->limitReached()) {
            $this->addError('label', 'Ücretsiz planda bir formda en fazla '.self::FREE_FIELD_LIMIT.' alan olabilir.');

            return;
        }

        $rules = array_filter([
            'min' => $this->min !== '' ? (int) $this->min : null,
            'max' => $this->max !== '' ? (int) $this->max : null,
            'pattern' => $this->pattern !== '' ? $this->pattern : null,
        ], fn ($value) => $value !== null);

        Fields::create([
            'form_id' => $this->formId,
            'type' => $this->type,
            'label' => trim($this->label),
            'placeholder' => trim($this->placeholder) ?: null,
            'help_text' => trim($this->helpText) ?: null,
            'is_required' => $this->isRequired,
            'options' => $this->isChoice() ? json_encode($this->filledOptions(), JSON_UNESCAPED_UNICODE) : null,
            'rules' => $rules ? json_encode($rules, JSON_UNESCAPED_UNICODE) : null,
            'position' => (int) $this->formModel->fields()->max('position') + 1,
        ]);

        $this->redirectRoute('formcraft.preview.fields', $this->formRoute);
    }

    /**
     * @return list<string>
     */
    private function filledOptions(): array
    {
        return array_values(array_filter(array_map('trim', $this->options), fn (string $option) => $option !== ''));
    }

    public function render()
    {
        return view('livewire.workspaces.forms.fields.create', [
            'form' => $this->formModel,
            'nextNumber' => $this->formModel->fields()->count() + 1,
        ])
            ->extends('formcraft.field-create')
            ->section('page');
    }
}
