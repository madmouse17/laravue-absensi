<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;
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
        Role::create(['name' => 'Manager']);
       $admin= Role::create(['name' => 'admin']);
        Role::create(['name' => 'pegawai']);

        $user = DB::table('users')->insert([
            'name' => "admin",
            'email' => 'admin@tes.com',
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($admin);

    }
}