<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * The sample accounts' emails, also used to clear them before re-seeding.
     */
    public const EMAILS = [
        'deniz@ornek.com',
        'ece@ornek.com',
        'mert@ornek.com',
        'burak@ornek.com',
    ];

    /**
     * The team shown on the members page. Deniz owns both sample workspaces and is on the pro plan; the others are on free.
     */
    public function run(): void
    {
        $people = [
            ['name' => 'Deniz Yılmaz', 'email' => 'deniz@ornek.com', 'plan' => User::PLAN_PRO],
            ['name' => 'Ece Kaya', 'email' => 'ece@ornek.com', 'plan' => User::PLAN_FREE],
            ['name' => 'Mert Aydın', 'email' => 'mert@ornek.com', 'plan' => User::PLAN_FREE],
            ['name' => 'Burak Demir', 'email' => 'burak@ornek.com', 'plan' => User::PLAN_FREE],
        ];

        foreach ($people as $person) {
            User::factory()->create($person);
        }
    }
}
