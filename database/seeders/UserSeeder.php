<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::create(['name' => 'Manager']);
       $admin= Role::create(['name' => 'coba']);
        // Role::create(['name' => 'pegawai']);

        $user = User::create([
            'name' => "coba",
            'email' => 'coba@tes.com',
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($admin);

    }
}