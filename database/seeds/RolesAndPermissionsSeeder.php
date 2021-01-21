<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // create permissions
        Permission::create(['name' => 'create users', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete users', 'guard_name' => 'api']);
        Permission::create(['name' => 'update users', 'guard_name' => 'api']);

        // create roles and assign created permissions

        // or may be done by chaining
        $role = Role::create(['name' => 'admin', 'guard_name' => 'api'])
            ->givePermissionTo([
                'create users',
                'delete users',
                'update users'
            ]);

        $role = Role::create(['name' => 'super-admin', 'guard_name' => 'api']);
        $role->givePermissionTo(Permission::all());
    }
}
