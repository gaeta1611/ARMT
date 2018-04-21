<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_employee = Role::where('name','employee')->first();
        $role_admin = Role::where('name','admin')->first();

        $admin = new User();
        $admin->lastname = 'Giordano';
        $admin->firstname = 'Gaetano';
        $admin->initials = 'GG';
        $admin->email = 'titeuf271@hotmail.com';
        $admin->language = 'fr';
        $admin->login = 'gaetano';
        $admin->password = bcrypt('gaetano');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $employee = new User();
        $employee->lastname = 'Croisy';
        $employee->firstname = 'Eric';
        $employee->initials = 'EC';
        $employee->email = 'eric.croisy@hotmail.com';
        $employee->language = 'fr';
        $employee->login = 'eric';
        $employee->password = bcrypt('eric');
        $employee->save();
        $employee->roles()->attach($role_employee);

        
    }
}
