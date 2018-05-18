<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            ['username' => 'superadmin', 'password' => Hash::make('superadmin'), 'role' => 1],
            ['username' => 'registrar', 'password' => Hash::make('registrar'), 'role' => 2],
            ['username' => 'accounting', 'password' => Hash::make('accounting'), 'role' => 3]
        ];

        DB::table('users')->insert($users);

    }
}
