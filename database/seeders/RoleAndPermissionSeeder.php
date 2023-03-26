<?php
/*
 * Produced: Wed Jun 29 2022
 * Author: Alec M.
 * GitHub: https://amattu.com/links/github
 * Copyright: (C) 2022 Alec M.
 * License: License GNU Affero General Public License v3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
    }
}
