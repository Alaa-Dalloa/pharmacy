<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
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
        $user=\App\Models\User::create(
        [
            'name'=>'super_admin',
            'email'=>'super_admin@gmail.com',
            'password' => Hash::make('secret1234'),
            'user_type'=>'super_admin',
        ]);

        $user->attachRole('super_admin');


        $user=\App\Models\User::create(
        [
            'name'=>'administor',
            'email'=>'administor@gmail.com',
            'password' => Hash::make('admin1234')

        ]);

        $user->attachRole('administor');



        $user=\App\Models\User::create(
        [
            'name'=>'Al_Ameen Warhouse',
            'email'=>'Al_Ameen Warhouse@gmail.com',
            'password' => Hash::make('rebo1234')

        ]);

        $user->attachRole('supplier');
    }
}
