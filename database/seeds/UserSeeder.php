<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(['name' => "admin",'email' => "admin@gt.com",'password' => bcrypt('admin123')]);

        $adminrole = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Chef Agence']);
        Role::create(['name' => 'Financier']);

        $permissions = Permission::pluck('id','id')->all();

        $adminrole->syncPermissions($permissions);

        $user->assignRole([$adminrole->id]);
    }
}
