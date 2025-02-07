<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'), // Secure password
            'role' => 'admin',
        ]);

        User::factory(5)->create([
            'role' => 'student'
        ]);
    }
}
