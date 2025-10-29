<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed academic levels (HND 1, HND 2, Bachelor)
        $this->call([
            LevelSeeder::class,
        ]);

        // Optionally create test users
        // User::factory(10)->create();

        // Create a default admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@smartcampus.com',
            'is_admin' => true,
        ]);

        $this->command->info('✓ Database seeding completed successfully!');
    }
}

