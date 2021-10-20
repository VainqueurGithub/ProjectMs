<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

           'role-list',

           'role-create',

           'role-edit',

           'role-delete',

           'exercice-list',

           'exercice-create',

           'exercice-edit',

           'exercice-delete'

        ];


        foreach ($permissions as $permission) {

             Permission::create(['name' => $permission]);

        }
    }
}
