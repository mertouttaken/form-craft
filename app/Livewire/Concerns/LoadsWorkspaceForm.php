<?php

namespace App\Livewire\Concerns;

use App\Models\Forms;
use App\Models\Workspaces;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;

/**
 * Finds the form from the /w/{workspace}/forms/{form} URL. The form is
 * looked up inside its workspace, so a slug from another workspace 404s.
 */
trait LoadsWorkspaceForm
{
    #[Locked]
    public int $workspaceId;

    #[Locked]
    public int $formId;

    protected function loadForm(string $workspace, string $form): void
    {
        $workspaceModel = Workspaces::where('slug', $workspace)->firstOrFail();

        $this->workspaceId = $workspaceModel->id;
        $this->formId = Forms::where('workspace_id', $workspaceModel->id)
            ->where('public_slug', $form)
            ->firstOrFail()
            ->id;
    }

    #[Computed]
    public function workspaceModel(): Workspaces
    {
        return Workspaces::findOrFail($this->workspaceId);
    }

    #[Computed]
    public function formModel(): Forms
    {
        return Forms::where('workspace_id', $this->workspaceId)->findOrFail($this->formId);
    }

    /**
     * Route parameters for links back to this form's pages.
     *
     * @return array{workspace: string, form: string}
     */
    #[Computed]
    public function formRoute(): array
    {
        return [
            'workspace' => $this->workspaceModel->slug,
            'form' => $this->formModel->public_slug,
        ];
    }
}
