<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $allPermissions = Permission::query()
            ->where('guard_name', 'web')
            ->pluck('name')
            ->all();

        $config = config('permissions.roles', []);

        foreach ($config as $roleName => $resources) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            if (isset($resources['*']) && in_array('*', $resources['*'], true)) {
                $excludedResources = $resources['except'] ?? [];

                $permissions = collect($allPermissions)
                    ->reject(function (string $permission) use ($excludedResources): bool {
                        foreach ($excludedResources as $resource) {
                            if (str_ends_with($permission, ":{$resource}")) {
                                return true;
                            }
                        }

                        return false;
                    })
                    ->values()
                    ->all();

                $role->syncPermissions($permissions);

                continue;
            }

            $permissions = [];

            foreach ($resources as $resource => $abilities) {
                if ($resource === 'widgets') {
                    foreach ($abilities as $permission) {
                        if (in_array($permission, $allPermissions, true)) {
                            $permissions[] = $permission;
                        }
                    }

                    continue;
                }

                foreach ($abilities as $ability) {
                    if ($ability === '*') {
                        $resourcePermissions = collect($allPermissions)
                            ->filter(
                                fn (string $permission): bool => str_ends_with(
                                    $permission,
                                    ":{$resource}",
                                ),
                            )
                            ->all();

                        $permissions = array_merge($permissions, $resourcePermissions);

                        continue;
                    }

                    $permission = "{$ability}:{$resource}";

                    if (in_array($permission, $allPermissions, true)) {
                        $permissions[] = $permission;
                    }
                }
            }

            $role->syncPermissions(array_unique($permissions));
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}