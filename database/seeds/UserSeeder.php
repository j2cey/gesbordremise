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
        $user2 = User::create(['name' => "chef agence",'email' => "agence@gt.com",'password' => bcrypt('admin123')]);
        $user3 = User::create(['name' => "finance",'email' => "finance@gt.com",'password' => bcrypt('admin123')]);

        $adminrole = Role::create(['name' => 'Admin']);
        $defaultrole = Role::create(['name' => 'Simple User']);
        $agencerole = Role::create(['name' => 'Chef Agence']);
        $financerole = Role::create(['name' => 'Financier']);

        $permissions = Permission::pluck('id','id')->all();

        $adminrole->syncPermissions($permissions);
        $agencerole->syncPermissions($permissions);
        $financerole->syncPermissions($permissions);

        $user->assignRole([$adminrole->id]);
        $user2->assignRole([$agencerole->id]);
        $user3->assignRole([$financerole->id]);
    }
}
