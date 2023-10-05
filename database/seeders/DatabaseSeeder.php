<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
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
        User::factory(5)->create();

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
    }
}
