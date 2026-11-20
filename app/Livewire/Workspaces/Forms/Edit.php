<?php

namespace App\Livewire\Workspaces\Forms;

use App\Livewire\Concerns\LoadsWorkspaceForm;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    use LoadsWorkspaceForm;

    /**
     * Status => [label, help, stamp modifier class].
     */
    public const STATUSES = [
        'draft' => ['Taslak', 'Sadece ekip görür', 'stamp--draft'],
        'published' => ['Yayında', 'Link açık, yanıt alır', ''],
        'closed' => ['Kapalı', 'Link açık değil', 'stamp--closed'],
    ];

    public string $title = '';

    public string $description = '';

    public string $status = 'draft';

    public string $successMessage = '';

    public string $redirectUrl = '';

    public bool $allowMultiple = false;

    public string $notifyEmail = '';

    public bool $saved = false;

    public function mount(string $workspace, string $form): void
    {
        $this->loadForm($workspace, $form);

        $model = $this->formModel;
        $settings = json_decode($model->settings ?? '[]', true) ?: [];

        $this->title = $model->title;
        $this->description = (string) $model->description;
        $this->status = $model->status;
        $this->successMessage = (string) ($settings['success_message'] ?? '');
        $this->redirectUrl = (string) ($settings['redirect_url'] ?? '');
        $this->allowMultiple = (bool) ($settings['allow_multiple'] ?? false);
        $this->notifyEmail = (string) ($settings['notify_email'] ?? '');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', Rule::in(array_keys(self::STATUSES))],
            'successMessage' => ['nullable', 'string', 'max:200'],
            'redirectUrl' => ['nullable', 'url:http,https', 'max:255'],
            'allowMultiple' => ['boolean'],
            'notifyEmail' => ['nullable', 'email', 'max:255'],
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
            'successMessage.max' => 'Mesaj en fazla 200 karakter olabilir.',
            'redirectUrl.url' => 'Adres http:// ya da https:// ile başlamalı.',
            'notifyEmail.email' => 'Geçerli bir e-posta adresi yaz.',
        ];
    }

    public function updated(): void
    {
        $this->saved = false;
    }

    public function save(): void
    {
        $this->validate();

        $this->formModel->update([
            'title' => trim($this->title),
            'description' => trim($this->description) ?: null,
            'status' => $this->status,
            'settings' => json_encode([
                'success_message' => trim($this->successMessage) ?: null,
                'redirect_url' => trim($this->redirectUrl) ?: null,
                'notify_email' => trim($this->notifyEmail) ?: null,
                'allow_multiple' => $this->allowMultiple,
            ], JSON_UNESCAPED_UNICODE),
        ]);

        unset($this->formModel);
        $this->saved = true;
    }

    /**
     * Delete the form. Its fields, submissions and answers go with it
     * (cascading foreign keys).
     */
    public function delete(): void
    {
        $workspace = $this->workspaceModel->slug;

        $this->formModel->delete();

        $this->redirectRoute('formcraft.preview.forms', ['workspace' => $workspace]);
    }

    public function render()
    {
        return view('livewire.workspaces.forms.edit', [
            'form' => $this->formModel,
            'fieldCount' => $this->formModel->fields()->count(),
            'submissionCount' => $this->formModel->submissions()->count(),
        ])
            ->extends('formcraft.form-edit')
            ->section('page');
    }
}
