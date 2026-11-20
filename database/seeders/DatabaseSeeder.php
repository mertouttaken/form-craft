<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workspaces;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the sample FormCraft data. Every account's password is "password".
     * Safe to run again: the previous sample rows are removed first.
     */
    public function run(): void
    {
        $this->removeSampleData();

        $this->call([
            UserSeeder::class,
            WorkspaceSeeder::class,
            InvitationSeeder::class,
            AralikBulusmasiSeeder::class,
            SampleFormSeeder::class,
        ]);
    }

    /**
     * Delete the previous sample rows. Forms, fields, submissions, answers,
     * invitations and memberships go with their workspace (cascading
     * foreign keys). Accounts that are not sample accounts stay.
     */
    private function removeSampleData(): void
    {
        Workspaces::whereIn('slug', WorkspaceSeeder::SLUGS)->delete();

        User::whereIn('email', UserSeeder::EMAILS)->delete();
    }
}
