<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Bikin admin
        User::factory()->create([
            'name' => 'Afra',
            'email' => 'narayaara@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Panggil seeder lain
        $this->call([
            SubjectSeeder::class,
            // MaterialSeeder::class,  // ⬅️ uncomment kalo udah ada
        ]);
    }
}