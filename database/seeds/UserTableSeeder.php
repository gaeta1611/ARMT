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
        $employee->lastname = 'Ruth';
        $employee->firstname = 'Cédryc';
        $employee->initials = 'CR';
        $employee->email = 'cedrycsys@hotmail.com';
        $employee->language = 'en';
        $employee->login = 'cedryc';
        $employee->password = bcrypt('cedryc');
        $employee->save();
        $employee->roles()->attach($role_employee);

        
    }
}
