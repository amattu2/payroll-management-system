<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.delete']);

        Permission::create(['name' => 'employees.view.self']);
        Permission::create(['name' => 'employees.view.all']);
        Permission::create(['name' => 'employees.create']);
        Permission::create(['name' => 'employees.update']);
        Permission::create(['name' => 'employees.delete']);
        Permission::create(['name' => 'employees.terminate']);

        Permission::create(['name' => 'settings.view']);
        Permission::create(['name' => 'settings.update']);

        // Create Roles
        if(!Role::where('name', 'Admin')->exists()) {
            Role::create(['name' => 'Admin'])->givePermissionTo(Permission::all());
        }

        User::first()->assignRole('Admin');
    }
}
