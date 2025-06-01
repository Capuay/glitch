<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    // Сначала категории
       \App\Models\Category::insert([
        ['name' => 'Экшен'],
        ['name' => 'РПГ'], 
        ['name' => 'Стратегии'],
      ]);
    
    // Затем игры через GamesTableSeeder
    $this->call([
        GamesTableSeeder::class
    ]);
}
}
