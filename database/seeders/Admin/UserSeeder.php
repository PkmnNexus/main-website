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
                'surname' => env('ADMIN_SURNAME'),
                'display_name' => 'Mr. Pokémon',
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

        // Bassie
        $bassie = User::updateOrCreate(
            [
                'email' => 'bastrahetfield@gmail.com',
            ],
            [
                'name' => 'Sebastiaan',
                'surname' => 'Elshout',
                'display_name' => 'Bastrahetfield',
                'slug' => 'bastrahetfield',
                'bio' => 'PKMN Nexus administrator.',
                'password' => Hash::make('7*mrsv*K4a9YG5wD'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        if (! $bassie->hasRole('admin')) {
            $bassie->assignRole('admin');
        }

        if (! app()->isProduction()) {
            // Editor
            $editorPassword = '_8%b{raT7i;z|~8}CZ{aCUm?y7qZOmW%';

            $editor = User::updateOrCreate(
                [
                    'email' => 'editor@pkmnnexus.com',
                ],
                [
                    'name' => 'Editor Test',
                    'surname' => 'Surname',
                    'display_name' => 'Editor Test',
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
            $authorPassword = 't#1fO8VcG6~f5d\^~7M$0KnD&MXp4Zq#';

            $author = User::updateOrCreate(
                [
                    'email' => 'author@pkmnnexus.com',
                ],
                [
                    'name' => 'Author Test',
                    'surname' => 'Surname',
                    'display_name' => 'Author Test',
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

            // Member
            $memberPassword = 'kU;4X2R_$%o3e{w$1U5c0-G,9VM{V**-';

            $member = User::updateOrCreate(
                [
                    'email' => 'member@pkmnnexus.com',
                ],
                [
                    'name' => 'Member Test',
                    'surname' => 'Surname',
                    'display_name' => 'Member Test',
                    'slug' => 'member-test',
                    'bio' => 'PKMN Nexus member.',
                    'password' => Hash::make($memberPassword),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]
            );

            if (! $member->hasRole('member')) {
                $member->assignRole('member');
            }

            $this->command->info('Editor login: editor@pkmnnexus.com');
            $this->command->info("Editor password: {$editorPassword}");

            $this->command->info('Author login: author@pkmnnexus.com');
            $this->command->info("Author password: {$authorPassword}");

            $this->command->info('Author login: member@pkmnnexus.com');
            $this->command->info("Author password: {$memberPassword}");
        }
    }
}