<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::updateOrCreate(
            [
                'email' => env('ADMIN_EMAIL'),
            ],
            [
                'name' => env('ADMIN_NAME'),
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'email_verified_at' => now(),
            ]
        );

        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Editor
        $editorPassword = \Str::password();

        $editor = User::updateOrCreate(
            [
                'email' => 'editor@pkmnnexus.com',
            ],
            [
                'name' => 'Editor',
                'password' => Hash::make($editorPassword),
                'email_verified_at' => now(),
            ]
        );

        if (! $editor->hasRole('editor')) {
            $editor->assignRole('editor');
        }

        // Author
        $authorPassword = \Str::password();

        $author = User::updateOrCreate(
            [
                'email' => 'author@pkmnnexus.com',
            ],
            [
                'name' => 'Author',
                'password' => Hash::make($authorPassword),
                'email_verified_at' => now(),
            ]
        );

        if (! $author->hasRole('author')) {
            $author->assignRole('author');
        }

        $this->command->info('Editor login: editor@pkmnnexus.com');
        $this->command->info("Editor password: {$editorPassword}");

        $this->command->info('Author login: author@pkmnnexus.com');
        $this->command->info("Author password: {$authorPassword}");
    }
}
