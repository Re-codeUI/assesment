<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AclSeed extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions.
        app()['cache']->forget('spatie.permission.cache');

        // seed the default permissions.
        $permissions = Permission::defaultPermissions();
        foreach ($permissions as $perms) {
            Permission::firstOrCreate([
                'name' => $perms,
                'guard_name' => 'web', // Tambahkan guard_name
            ]);
        }
        $this->command->info('Default Permissions added.');

        // seed the default roles.
        $roles = Role::defaultRoles();
        foreach ($roles as $role) {
            $role = Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web', // Tambahkan guard_name
            ]);

            // assign all permissions to admin role.
            if ($role->name == 'admin') {
                $role->givePermissionTo(Permission::all());
            }
        }

        $this->command->info('Default Roles added.');
    }
}

