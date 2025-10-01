<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FilamentAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@filament.test'],
            [
                'name' => 'Filament Admin',
                'email_verified_at' => Carbon::now(),
                'password' => 'password',
            ],
        );
    }
}
