<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only seed test users in local and staging environments.
        if (! app()->environment(['local', 'staging'])) {
            return;
        }

        // Create exactly 500 recognizable test accounts.
        for ($number = 1; $number <= 500; $number++) {
            $createdAt = Carbon::now()->subDays(random_int(0, 730));
            $isSuspended = $number % 50 === 0;
            $isInactive = $number % 25 === 0;

            $user = User::updateOrCreate(
                [
                    'email' => sprintf('testuser%03d@pkmnexus.test', $number),
                ],
                [
                    'name' => fake()->firstName(),
                    'surname' => fake()->lastName(),
                    'display_name' => sprintf('Test Trainer %03d', $number),
                    'slug' => sprintf('test-user-%03d', $number),
                    'bio' => fake()->optional(0.7)->paragraph(),
                    'password' => Hash::make('password'),
                    'email_verified_at' => $createdAt,
                    'is_active' => ! $isInactive,
                    'last_login_at' => $number % 10 === 0
                        ? null
                        : Carbon::now()->subDays(random_int(0, 90)),
                    'last_activity_at' => $number % 8 === 0
                        ? null
                        : Carbon::now()->subDays(random_int(0, 30)),
                    'suspended_at' => $isSuspended
                        ? Carbon::now()->subDays(random_int(1, 14))
                        : null,
                    'suspended_until' => $isSuspended
                        ? Carbon::now()->addDays(random_int(1, 14))
                        : null,
                    'suspended_reason' => $isSuspended
                        ? fake()->sentence()
                        : null,
                    'created_at' => $createdAt,
                ],
            );

            // Assign the member role.
            $user->syncRoles(['member']);
        }
    }
}