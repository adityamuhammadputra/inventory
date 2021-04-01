<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'avatar' => '/images/avatars/1.jpg',
                'phone' => '0812345678',
                'status' => 1,
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'avatar' => '/images/avatars/avatar.jpg',
                'phone' => '0912345678',
                'status' => 1,
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'user dua',
                'email' => 'user2@gmail.com',
                'avatar' => '/images/avatars/avatar-2.jpg',
                'phone' => '0912345678',
                'status' => 1,
                'password' => Hash::make('password'),
                'created_at' => Carbon::now()
            ],
        ]);
    }
}
