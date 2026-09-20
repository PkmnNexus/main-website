<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $config = config('permissions.roles', []);

        foreach ($config as $roleName => $resources) {
            $role = Role::findByName($roleName);

            if (isset($resources['*']) && in_array('*', $resources['*'], true)) {
                $role->syncPermissions(Permission::all());

                continue;
            }

            $permissions = [];

            foreach ($resources as $resource => $abilities) {
                foreach ($abilities as $ability) {
                    $permission = "{$ability}_{$resource}";

                    if (Permission::where('name', $permission)->exists()) {
                        $permissions[] = $permission;
                    }
                }
            }

            $role->syncPermissions($permissions);
        }
    }
}
