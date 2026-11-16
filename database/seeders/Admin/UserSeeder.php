<?php

namespace Database\Seeders\Admin;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure Super Admin role exists
        Role::findOrCreate('super_admin', 'web');

        // Admin / Super Admin
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

        $admin->syncRoles(['super_admin']);

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
    }
}