<?php

use Carbon\Carbon;
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
        DB::table('Barangs')->insert([
            [
                'id' => uuid(),
                'kategori' => 'IP',
                'kategori_no' => '001',
                'kode' => 'IP001',
                'barcode' => '/img/barcode/IP001.svg',
                'jenis' => 'Jenis1',
                'merk' => 'Merk1',
                'type' => 'Type1',
                'serial_number' => '0812345678',
                'kondisi' => 1,
                'harga' => '600000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'user_id' => 1,
            ],
            [
                'id' => uuid(),
                'kategori' => 'IP',
                'kategori_no' => '002',
                'kode' => 'IP002',
                'barcode' => '/img/barcode/IP002.svg',
                'jenis' => 'Jenis1',
                'merk' => 'Merk1',
                'type' => 'Type1',
                'serial_number' => '0812345678',
                'kondisi' => 1,
                'harga' => '400000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'user_id' => 1,
            ],
            [
                'id' => uuid(),
                'kategori' => 'IP',
                'kategori_no' => '003',
                'kode' => 'IP003',
                'barcode' => '/img/barcode/IP003.svg',
                'jenis' => 'Jenis3',
                'merk' => 'Merk3',
                'type' => 'Type3',
                'serial_number' => '0812345678',
                'kondisi' => 0,
                'harga' => '500000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'user_id' => 1,
            ],
            [
                'id' => uuid(),
                'kategori' => 'EP',
                'kategori_no' => '001',
                'kode' => 'EP001',
                'barcode' => '/img/barcode/EP001.svg',
                'jenis' => 'Jenis1',
                'merk' => 'Merk1',
                'type' => 'Type1',
                'serial_number' => '0812345678',
                'kondisi' => 1,
                'harga' => '2000000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'user_id' => 1,
            ],
            [
                'id' => uuid(),
                'kategori' => 'EP',
                'kategori_no' => '002',
                'kode' => 'EP002',
                'barcode' => '/img/barcode/EP002.svg',
                'jenis' => 'Jenis2',
                'merk' => 'Merk2',
                'type' => 'Type2',
                'serial_number' => '0812345678',
                'kondisi' => 0,
                'harga' => '1000000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'user_id' => 1,
            ],
            [
                'id' => uuid(),
                'kategori' => 'EP',
                'kategori_no' => '003',
                'kode' => 'EP003',
                'barcode' => '/img/barcode/EP003.svg',
                'jenis' => 'Jenis2',
                'merk' => 'Merk2',
                'type' => 'Type2',
                'serial_number' => '0812345678',
                'kondisi' => 0,
                'harga' => '2500000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'user_id' => 1,
            ],
        ]);
    }
}
