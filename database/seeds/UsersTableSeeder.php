<?php

use Illuminate\Database\Seeder;
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
        $user = new \App\User;
        $user->name = 'Demo';
        $user->email = 'demo@example.com';
        $user->password = Hash::make('demodemo');
        $user->save();
        
        factory(\App\User::class, 2)->create();
    }
}
