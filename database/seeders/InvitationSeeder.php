<?php

namespace Database\Seeders;

use App\Models\Invitations;
use App\Models\Workspaces;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvitationSeeder extends Seeder
{
    /**
     * Pending invitations shown on the members page.
     * Selin's token is fixed so the invitation preview URL stays stable.
     */
    public function run(): void
    {
        $workspace = Workspaces::where('slug', 'deniz')->firstOrFail();

        Invitations::create([
            'workspace_id' => $workspace->id,
            'email' => 'selin@ornek.com',
            'role' => 'editor',
            'token' => 'ornek-davet-selin',
            'expires_at' => now()->addDays(5),
        ]);

        Invitations::create([
            'workspace_id' => $workspace->id,
            'email' => 'kaan@ornek.com',
            'role' => 'viewer',
            'token' => Str::random(64),
            'expires_at' => now()->addDays(2),
        ]);
    }
}
