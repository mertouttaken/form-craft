<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workspace_User;
use App\Models\Workspaces;
use Illuminate\Database\Seeder;

class WorkspaceSeeder extends Seeder
{
    /**
     * The sample workspaces' slugs, also used to clear them before re-seeding.
     */
    public const SLUGS = ['deniz', 'pro-ekibi'];

    /**
     * Two workspaces: Deniz's free one (the forms in the preview pages)
     * and a pro team, so data isolation between workspaces can be tested.
     */
    public function run(): void
    {
        $users = User::query()->pluck('id', 'email');

        $free = Workspaces::create([
            'name' => "Deniz Yılmaz'ın alanı",
            'slug' => 'deniz',
            'owner_id' => $users['deniz@ornek.com'],
            'plan' => 'free',
        ]);

        $pro = Workspaces::create([
            'name' => 'Pro ekibi',
            'slug' => 'pro-ekibi',
            'owner_id' => $users['deniz@ornek.com'],
            'plan' => 'pro',
        ]);

        $memberships = [
            [$free, 'deniz@ornek.com', 'owner'],
            [$free, 'ece@ornek.com', 'editor'],
            [$free, 'mert@ornek.com', 'viewer'],
            [$free, 'burak@ornek.com', 'editor'],
            [$pro, 'deniz@ornek.com', 'owner'],
            [$pro, 'ece@ornek.com', 'editor'],
        ];

        foreach ($memberships as [$workspace, $email, $role]) {
            Workspace_User::create([
                'workspace_id' => $workspace->id,
                'user_id' => $users[$email],
                'role' => $role,
            ]);
        }
    }
}
