<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create basic genres
        $genres = [
            ['name' => 'Action'],
            ['name' => 'Adventure'],
            ['name' => 'Comedy'],
            ['name' => 'Drama'],
            ['name' => 'Horror'],
            ['name' => 'Romance'],
            ['name' => 'Sci-Fi'],
            ['name' => 'Thriller'],
            ['name' => 'Documentary'],
            ['name' => 'Animation'],
            ['name' => 'Crime'],
            ['name' => 'Fantasy'],
            ['name' => 'Mystery'],
            ['name' => 'War'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}
