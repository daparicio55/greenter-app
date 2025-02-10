<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrador = User::create([
            'name' => 'Davis Aparicio Palomino',
            'email' => 'dwaparicicio@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        //roles y permisos
        $role1 = Role::create(['name' => 'administrador']);
        $role2 = Role::create(['name' => 'cliente']);

        $permision1 = Permission::create(['name' => 'dashboard.clientes.index'])
        ->assignRole($role1);
        $permision2 = Permission::create(['name' => 'dashboard.clientes.create'])
        ->assignRole($role1);
        $permision3 = Permission::create(['name' => 'dashboard.clientes.store'])
        ->assignRole($role1);
        $permision4 = Permission::create(['name' => 'dashboard.clientes.edit'])
        ->assignRole($role1);
        $permision5 = Permission::create(['name' => 'dashboard.clientes.show'])
        ->assignRole($role1);
        $permision6 = Permission::create(['name' => 'dashboard.clientes.update'])
        ->assignRole($role1);
        $permision7 = Permission::create(['name' => 'dashboard.clientes.destroy'])
        ->assignRole($role1);

        $administrador->assignRole($role1);

    }
}
