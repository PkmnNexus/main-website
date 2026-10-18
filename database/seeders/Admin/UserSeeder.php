<?php

namespace Database\Seeders\Admin;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                'username' => 'Mr. Pokémon',
                'slug' => 'mr-pokemon',
                'bio' => 'PKMN Nexus administrator.',
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        if (app()->isLocal()) {
            // Editor
            $editorPassword = Str::password();

            $editor = User::updateOrCreate(
                [
                    'email' => 'editor@pkmnnexus.com',
                ],
                [
                    'name' => 'Editor Test',
                    'username' => 'Editor Test',
                    'slug' => 'editor-test',
                    'bio' => 'PKMN Nexus editor.',
                    'password' => Hash::make($editorPassword),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]
            );

            if (! $editor->hasRole('editor')) {
                $editor->assignRole('editor');
            }

            // Author
            $authorPassword = Str::password();

            $author = User::updateOrCreate(
                [
                    'email' => 'author@pkmnnexus.com',
                ],
                [
                    'name' => 'Author Test',
                    'username' => 'Author Test',
                    'slug' => 'author-test',
                    'bio' => 'PKMN Nexus author.',
                    'password' => Hash::make($authorPassword),
                    'email_verified_at' => now(),
                    'is_active' => true,
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
}