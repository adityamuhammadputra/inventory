<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Barangs')->insert(
            [
                'id' => Str::uuid(),
                'email' => 'admin@gmail.com',
                'avatar' => 'avatars/1.jpg',
                'phone' => '0812345678',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'avatar' => 'avatars/avatar.jpg',
                'phone' => '0912345678',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'user dua',
                'email' => 'user2@gmail.com',
                'avatar' => 'avatars/avatar-2.jpg',
                'phone' => '0912345678',
                'password' => Hash::make('password'),
            ],
        );
    }
}
