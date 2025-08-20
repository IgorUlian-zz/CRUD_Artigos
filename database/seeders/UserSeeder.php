<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Beatriz Carmelin',
            'email' => 'beatriz.carmelin@gmail.com',
            'password' => Hash::make('12345678'),
    ]);

        User::create([
            'name' => 'Osmair Antonio',
            'email' => 'osmair.antonio@gmail.com',
            'password' => Hash::make('12345678'),
    ]);

       User::create([
            'name' => 'Magda Aparecida',
            'email' => 'magda.aparecida@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Kauane Ulian',
            'email' => 'kauane.ulian@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Fernando Garcia',
            'email' => 'fernando.garcia@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

    }
}
