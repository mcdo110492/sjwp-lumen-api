<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new = Carbon::now();

        $users = [
            ['username' => 'superadmin', 'password' => Hash::make('superadmin'), 'role' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['username' => 'registrar', 'password' => Hash::make('registrar'), 'role' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['username' => 'accounting', 'password' => Hash::make('accounting'), 'role' => 3, 'created_at' => $now, 'updated_at' => $now]
        ];

        DB::table('users')->insert($users);

    }
}
