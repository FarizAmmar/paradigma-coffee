<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Employee
        User::factory(2)->create();

        // Admin
        User::create([
            'username' => 'root',
            'email' => 'root@gmail.com',
            'password' => bcrypt('root'),
            'access' => 'ADM'
        ]);

        // Menu Categories
        Category::create([
            'code' => 'COF',
            'description' => 'Coffee'
        ]);

        Category::create([
            'code' => 'NON',
            'description' => 'Non Coffee'
        ]);

        Category::create([
            'code' => 'SNC',
            'description' => 'Snack'
        ]);


        // Menus
        Menu::create([
            'name' => 'Green Mojito',
            'description' => 'Mojito rasa melon dengan keindahannya',
            'amount' => '28000',
            'image_path' => '1696784034.jpg',
            'category_code' => 'NON',
        ]);

        Menu::create([
            'name' => 'Bungalaw Classic',
            'description' => 'Coffee classic dengan black aren',
            'amount' => '23000',
            'image_path' => '1696784177.jpg',
            'category_code' => 'COF',
        ]);
    }
}
