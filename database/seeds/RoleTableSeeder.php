<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = new Role();
        $employee->name = 'employee';
        $employee->description = 'Employee account';
        $employee->save();

        $admin = new Role();
        $admin->name = 'admin';
        $admin->description = 'Administrator account';
        $admin->save();
    }
}
