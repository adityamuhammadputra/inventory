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
        DB::table('Barangs')->insert(
            [
                'id' => uuid(),
                'kategori' => 'IP',
                'kode' => 'IP001',
                'barcode' => 'images/barcode/IP001.png',
                'jenis' => 'Jenis1',
                'merk' => 'Merk1',
                'type' => 'Type1',
                'serial_number' => '0812345678',
                'kondisi' => 1,
                'harga' => '2000000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'id' => uuid(),
                'kategori' => 'IP',
                'kode' => 'IP002',
                'barcode' => 'images/barcode/IP002.png',
                'jenis' => 'Jenis1',
                'merk' => 'Merk1',
                'type' => 'Type1',
                'serial_number' => '0812345678',
                'kondisi' => 1,
                'harga' => '2000000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'id' => uuid(),
                'kategori' => 'IP',
                'kode' => 'IP003',
                'barcode' => 'images/barcode/IP003.png',
                'jenis' => 'Jenis3',
                'merk' => 'Merk3',
                'type' => 'Type3',
                'serial_number' => '0812345678',
                'kondisi' => 2,
                'harga' => '2000000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'id' => uuid(),
                'kategori' => 'EP',
                'kode' => 'EP001',
                'barcode' => 'images/barcode/EP001.png',
                'jenis' => 'Jenis1',
                'merk' => 'Merk1',
                'type' => 'Type1',
                'serial_number' => '0812345678',
                'kondisi' => 2,
                'harga' => '2000000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'id' => uuid(),
                'kategori' => 'EP',
                'kode' => 'EP002',
                'barcode' => 'images/barcode/EP002.png',
                'jenis' => 'Jenis2',
                'merk' => 'Merk2',
                'type' => 'Type2',
                'serial_number' => '0812345678',
                'kondisi' => 2,
                'harga' => '2000000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'id' => uuid(),
                'kategori' => 'EP',
                'kode' => 'EP003',
                'barcode' => 'images/barcode/EP003.png',
                'jenis' => 'Jenis2',
                'merk' => 'Merk2',
                'type' => 'Type2',
                'serial_number' => '0812345678',
                'kondisi' => 2,
                'harga' => '2000000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
        );
    }
}
