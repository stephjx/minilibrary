<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@libraryms.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@libraryms.com',
                'password' => bcrypt('password'),
            ]
        );
    }
}
