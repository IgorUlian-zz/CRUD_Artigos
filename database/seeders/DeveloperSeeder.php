<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Developer;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Developer::create([
            'name' => 'Beatriz Carmelin',
            'email' => 'beatriz.carmelin@gmail.com',
            'password' => '12345678',
            'senority' => 'Sr',
            'tags' => ['PHP', 'Laravel', 'Livewire']
        ]);

        Developer::create([
            'name' => 'Osmair Antonio',
            'email' => 'osmair.antonio@gmail.com',
            'password' => '12345678',
            'senority' => 'Pl',
            'tags' => ['Java', 'Spring', 'NoSQL']
        ]);

        Developer::create([
            'name' => 'Magda Aparecida',
            'email' => 'magda.aparecida@gmail.com',
            'password' => '12345678',
            'senority' => 'Jr',
            'tags' => ['NodeJS', 'Javascript', 'MySQL']
        ]);

        Developer::create([
            'name' => 'Kauane Ulian',
            'email' => 'kauane.ulian@gmail.com',
            'password' => '12345678',
            'senority' => 'Pl',
            'tags' => ['NextJS', 'JavaScript', 'PostgreSQL']
        ]);

        Developer::create([
        'name' => 'Fernando Garcia',
        'email' => 'fernando.garcia@gmail.com',
        'password' => '12345678',
        'senority' => 'Jr',
        'tags' => ['C++', 'Unity3D', 'C#']

        ]);
    }
}
