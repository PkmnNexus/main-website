<?php

namespace Database\Seeders;

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
        $this->call([
            Admin\RoleSeeder::class,
            Admin\RolePermissionSeeder::class,
            Admin\UserSeeder::class,

            PageSeeder::class,

            CategorySeeder::class,
            MediaFolderSeeder::class,
            AssetSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
