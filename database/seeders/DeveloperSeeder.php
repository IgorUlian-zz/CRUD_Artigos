<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Developer;
use App\Models\User;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user1 = User::find(1);

        $user2 = User::find(2);

        $user3 = User::find(3);

        $user4 = User::find(4);

        $user5 = User::find(5);

        $user1->developer()->create([
            'seniority' => 'Sr',
            'tags' => ['PHP', 'Laravel', 'Livewire']
        ]);

        $user2->developer()->create([
            'seniority' => 'Pl',
            'tags' => ['Java', 'Spring', 'NoSQL']
        ]);

        $user3->developer()->create([
            'seniority' => 'Jr',
            'tags' => ['NodeJS', 'Javascript', 'MySQL']
        ]);

        $user4->developer()->create([
            'seniority' => 'Pl',
            'tags' => ['NextJS', 'JavaScript', 'PostgreSQL']
        ]);

        $user5->developer()->create([
            'seniority' => 'Jr',
            'tags' => ['C++', 'Unity3D', 'C#']

        ]);
    }
}
