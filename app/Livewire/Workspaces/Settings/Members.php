<?php

namespace App\Livewire\Workspaces\Settings;

use App\Models\Invitations;
use App\Models\User;
use App\Models\Workspace_User;
use App\Models\Workspaces;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Members extends Component
{
    /**
     * Roles that can be given from this page. The owner role is never handed out here.
     */
    public const ROLES = [
        'editor' => 'Editör',
        'viewer' => 'İzleyici',
    ];

    #[Locked]
    public int $workspaceId;

    public string $inviteEmail = '';

    public string $inviteRole = 'editor';

    public ?string $notice = null;

    public function mount(string $workspace): void
    {
        $this->workspaceId = Workspaces::where('slug', $workspace)->firstOrFail()->id;
    }

    #[Computed]
    public function workspaceModel(): Workspaces
    {
        return Workspaces::findOrFail($this->workspaceId);
    }

    /**
     * Change a member's role. Owners are left alone.
     */
    public function updateRole(int $userId, string $role): void
    {
        abort_unless(array_key_exists($role, self::ROLES), 422);

        $this->membership($userId)->update(['role' => $role]);
        $this->notice = 'Rol güncellendi.';
    }

    public function removeMember(int $userId): void
    {
        $this->membership($userId)->delete();
        $this->notice = 'Üye çıkarıldı.';
    }

    public function invite(): void
    {
        $this->inviteEmail = Str::lower(trim($this->inviteEmail));

        $this->validate([
            'inviteEmail' => ['required', 'email', 'max:255'],
            'inviteRole' => ['required', Rule::in(array_keys(self::ROLES))],
        ], [
            'inviteEmail.required' => 'Davet edilecek e-postayı yaz.',
            'inviteEmail.email' => 'Geçerli bir e-posta adresi yaz.',
        ]);

        $alreadyMember = User::where('email', $this->inviteEmail)
            ->whereHas('workspaces', fn ($query) => $query->whereKey($this->workspaceId))
            ->exists();

        if ($alreadyMember) {
            $this->addError('inviteEmail', 'Bu kişi zaten ekipte.');

            return;
        }

        $pending = Invitations::where('workspace_id', $this->workspaceId)
            ->where('email', $this->inviteEmail)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->exists();

        if ($pending) {
            $this->addError('inviteEmail', 'Bu adrese gönderilmiş, süresi dolmamış bir davet var.');

            return;
        }

        Invitations::create([
            'workspace_id' => $this->workspaceId,
            'email' => $this->inviteEmail,
            'role' => $this->inviteRole,
            'token' => Str::random(64),
            'expires_at' => now()->addDays(7),
        ]);

        $this->reset('inviteEmail', 'inviteRole');
        $this->notice = 'Davet oluşturuldu.';
    }

    public function revokeInvitation(int $invitationId): void
    {
        Invitations::where('workspace_id', $this->workspaceId)
            ->whereNull('accepted_at')
            ->whereKey($invitationId)
            ->firstOrFail()
            ->delete();

        $this->notice = 'Davet geri alındı.';
    }

    private function membership(int $userId): Workspace_User
    {
        return Workspace_User::where('workspace_id', $this->workspaceId)
            ->where('user_id', $userId)
            ->where('role', '!=', 'owner')
            ->firstOrFail();
    }

    public function render()
    {
        $members = $this->workspaceModel->users()
            ->orderByRaw("case workspace_user.role when 'owner' then 0 when 'editor' then 1 else 2 end")
            ->orderBy('name')
            ->get();

        $invitations = Invitations::where('workspace_id', $this->workspaceId)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->orderBy('expires_at')
            ->get();

        return view('livewire.workspaces.settings.members', [
            'members' => $members,
            'invitations' => $invitations,
        ])
            ->extends('formcraft.members')
            ->section('page');
    }
}
