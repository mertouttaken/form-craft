<?php

namespace App\Livewire\Workspaces\Forms;

use App\Models\Forms;
use App\Models\User;
use App\Models\Workspaces;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Index extends Component
{
    public const STATUSES = ['published', 'draft', 'closed'];

    /**
     * Free plan: at most this many forms in a workspace.
     */
    public const FREE_FORM_LIMIT = 3;

    public ?string $search = '';

    #[Locked]
    public string $status = 'all';

    #[Locked]
    public ?int $workspaceId = null;

    /**
     * /w/{workspace}/forms shows that workspace. /dashboard has no
     * workspace in the URL, so it shows the signed-in user's first one
     * (a new account gets a personal workspace here).
     */
    public function mount(?string $workspace = null): void
    {
        if ($workspace !== null) {
            $this->workspaceId = Workspaces::where('slug', $workspace)->firstOrFail()->id;

            return;
        }

        $this->workspaceId = auth()->user()?->personalWorkspace()->id;
    }

    public function filter(string $status): void
    {
        if ($status === 'all' || in_array($status, self::STATUSES, true)) {
            $this->status = $status;
        }
    }

    #[Computed]
    public function workspaceModel(): ?Workspaces
    {
        return $this->workspaceId ? Workspaces::find($this->workspaceId) : null;
    }

    /**
     * The free plan's form limit. The signed-in user's plan decides;
     * without a user, the workspace's plan does.
     */
    public static function limitReached(?Workspaces $workspace, ?User $user): bool
    {
        if (! $workspace) {
            return false;
        }

        $isFree = $user ? $user->isFree() : $workspace->plan === 'free';

        return $isFree && $workspace->forms()->count() >= self::FREE_FORM_LIMIT;
    }

    public function render(): View
    {
        $workspace = $this->workspaceModel;

        /** @var Collection<int, Forms> $all */
        $all = $workspace
            ? $workspace->forms()->withCount('fields')->latest('updated_at')->get()
            : collect();

        $counts = $all->countBy('status');
        $query = $this->normalize($this->search ?? '');

        $forms = $all
            ->filter(fn (Forms $form) => $this->status === 'all' || $form->status === $this->status)
            ->filter(fn (Forms $form) => $query === '' || str_contains($this->normalize($form->title), $query))
            ->values();

        return view('livewire.workspaces.forms.index', [
            'workspace' => $workspace,
            'forms' => $forms,
            'hasForms' => $all->isNotEmpty(),
            'counts' => [
                'all' => $all->count(),
                'published' => $counts->get('published', 0),
                'draft' => $counts->get('draft', 0),
                'closed' => $counts->get('closed', 0),
            ],
            'limitReached' => self::limitReached($workspace, auth()->user()),
            'limit' => self::FREE_FORM_LIMIT,
        ])
            ->extends('formcraft.forms')
            ->section('page');
    }

    /**
     * Lower-case with Turkish dotted and dotless i, so "İzmir" matches "izmir".
     */
    private function normalize(string $text): string
    {
        return mb_strtolower(str_replace(['I', 'İ'], ['ı', 'i'], trim($text)));
    }
}
