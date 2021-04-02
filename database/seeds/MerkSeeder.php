<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merks')->insert([
            [
                'id' => 1,
                'nama' => 'Sony',
                'keterangan' => 'keterangan 1 lorem ipsum is amet',
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'nama' => 'Samsung',
                'keterangan' => 'keterangan 2 lorem ipsum is amet',
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'nama' => 'Cannon',
                'keterangan' => 'keterangan 3 lorem ipsum is amet',
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'nama' => 'Nikkon',
                'keterangan' => 'keterangan 4 lorem ipsum is amet',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
