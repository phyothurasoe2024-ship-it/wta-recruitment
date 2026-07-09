<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@wta.test'],
            [
                'name'              => 'WTA Admin',
                'password'          => Hash::make('password'),
                'is_admin'          => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command?->info(sprintf(
            'Admin user ready: %s (password: %s)',
            $admin->email,
            'password'
        ));
    }
}
