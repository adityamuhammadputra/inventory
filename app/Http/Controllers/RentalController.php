<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Rental;
use App\RentalBarang;
use App\RentalBarangItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{

    protected $noReg;
    public function index(Request $request)
    {
        $this->noReg = 'RE00001';

        $data = (object) [
            'noReg' => $this->noReg,
            'dateNow' => Carbon::now()->format('d F Y')
        ];

        return view('rental.index', compact('data'));
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
            $rental = $request->only('noreg', 'nama', 'kontak', 'alamat', 'diskon');
            $rental['id'] = uuid();
            $rental['start'] = dateInput($request->start);
            $rental['end'] = dateInput($request->end);
            $rental['sub_total'] = inputRupiah($request->sub_total);
            $rental['total'] = inputRupiah($request->total);
            $rental['user_id'] = userId();
            Rental::create($rental);

            $idRentalBarang = [];
            if($request->equpment) :
                $barangs = [];
                foreach($request->equpment as $key => $barang) :
                    $barangDb = Barang::where('kode', explode(' - ', $barang)[0])->first();
                    $barang_id = $barangDb->id;
                    $barang_name = $barangDb->merk;
                    $barang_temp = inputRupiah($barangDb->harga);
                    $barang_harga = inputRupiah(explode(' - ', $barang)[2]);
                    $uuid = uuid();
                    $idRentalBarang [$key] = [$key => $uuid];
                    $barangs [] = [
                        'id' => $uuid,
                        'rental_id' => $rental['id'],
                        'barang_id' => $barang_id,
                        'barang_name' => $barang_name,
                        'barang_temp' => $barang_temp,
                        'barang_harga' => $barang_harga,
                        'barang_total' => inputRupiah($request->price[$key]),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                endforeach;
                RentalBarang::insert($barangs);
            endif;

            if($request->item) :
                $items = [];
                foreach($request->item as $key => $item) :
                    foreach($item as $subKey => $subItem) :
                        $barangDb = Barang::where('kode', explode(' - ', $subItem)[0])->first();
                        $barang_id = $barangDb->id;
                        $barang_name = $barangDb->merk;
                        $barang_temp = inputRupiah($barangDb->harga);
                        $barang_harga = inputRupiah(explode(' - ', $subItem)[2]);
                        $items [] = [
                            'id' => uuid(),
                            'rental_barang_id' => $idRentalBarang[$key][$key],
                            'barang_id' => $barang_id,
                            'barang_name' => $barang_name,
                            'barang_temp' => $barang_temp,
                            'barang_harga' => $barang_harga,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];

                    endforeach;

                endforeach;
                RentalBarangItem::insert($items);
            endif;
        DB::commit();

    }
}
