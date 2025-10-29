<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds the levels table with the three main academic levels:
     * - HND 1 (Higher National Diploma Year 1)
     * - HND 2 (Higher National Diploma Year 2)
     * - Bachelor (Bachelor's Degree)
     */
    public function run(): void
    {
        // Clear existing levels (optional - remove if you want to preserve data)
        Level::query()->delete();

        // Define the academic levels
        $levels = [
            [
                'name' => 'HND 1',
                'slug' => 'hnd-1',
                'description' => 'Higher National Diploma Year 1 - Foundation year covering fundamental concepts and introductory courses across various disciplines. Students build a strong base for advanced studies.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'HND 2',
                'slug' => 'hnd-2',
                'description' => 'Higher National Diploma Year 2 - Advanced year building upon HND 1 foundations with specialized courses, practical applications, and preparation for professional certification or Bachelor\'s progression.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bachelor',
                'slug' => 'bachelor',
                'description' => 'Bachelor\'s Degree Program - Comprehensive undergraduate program offering in-depth study, research opportunities, and advanced coursework leading to a Bachelor\'s degree in your chosen field.',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        // Insert levels into the database
        foreach ($levels as $levelData) {
            Level::create($levelData);
        }

        // Output success message
        $this->command->info('✓ Successfully seeded ' . count($levels) . ' academic levels');
        $this->command->info('  - HND 1 (Order: 1)');
        $this->command->info('  - HND 2 (Order: 2)');
        $this->command->info('  - Bachelor (Order: 3)');
    }
}
