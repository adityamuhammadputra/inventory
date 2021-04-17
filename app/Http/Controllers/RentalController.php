<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Client;
use App\Rental;
use App\RentalBarang;
use App\RentalBarangItem;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RentalController extends Controller
{

    public function index(Request $request)
    {

        $data = (object) [
            'noReg' => getMaxRental(),
            'dateNow' => Carbon::now()->format('d F Y'),
            'method' => 'POST',
            'action' => "/rental",
            'event' => null,
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
            $rental['status'] = 1;
            $rentalDb = Rental::create($rental);

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
                        'rental_id' => $rentalDb->id,
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
                        if(!$request->item[$key][$subKey] == null) :
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
                        endif;
                    endforeach;
                endforeach;
                RentalBarangItem::insert($items);
            endif;


            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection();
            $description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
            $section->addText($description);
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            try {
                $objWriter->save(storage_path("app/inv/{$rentalDb->id}.docx"));
            } catch (Exception $e) {
                dd($e);
            }
            // return response()->download(storage_path("app/inv/{$rentalDb->id}.docx"));
        DB::commit();

        $data = [
            'noReg' => getMaxRental(),
            'status' => 200,
        ];

        return response()->json($data, 200);
    }


    public function dataTable(Request $request)
    {
        $rental = Rental::with('rentalBarangs')->filtered();

        return DataTables::of($rental)
            ->addColumn('action', function ($data) {
                return '<a data-id="'.$data->id.'"
                            data-title="Rental #' . $data->noreg . '"
                            data-url="/rental/'.$data->id.'/approve"
                            class="text-primary approveData"><i class="fa fa-check"></i>
                        </a>
                        <a href="/rental/'.$data->id.'/edit"
                            class="text-info"><i class="fa fa-info-circle"></i>
                        </a>
                        <a data-id="' . $data->id . '"
                            data-title="' . $data->kode . '"
                            data-url="/rental/'.$data->id.'"
                            class="text-danger deleteData"><i class="fa fa-trash"></i>
                        </a>';
            })
            ->addColumn('count_equipment', function ($data) {
                return $data->rentalBarangs->count();
            })
            ->addColumn('count_item', function ($data) {
                return $data->rentalBarangs->sum('count_item');
            })
            ->rawColumns(['action', 'count_equipment', 'count_item'])
            ->make(true);
    }

    public function show($id)
    {
        $event = Rental::with('rentalBarangs')
                        ->findOrFail($id);
        return $event;
    }

    public function edit($id)
    {
        $rental = Rental::with('rentalBarangs')
                        ->findOrFail($id);

        $data = (object) [
            'noReg' => $rental->noreg,
            'dateNow' => $rental->start,
            'method' => 'PATCH',
            'action' => "/rental/$rental->id",
            'rental' => $rental,
        ];

        return view('rental.edit', compact('data'));
    }

    public function destroy(Rental $rental)
    {
        return $rental;
    }

    public function approve(Request $request, Rental $rental)
    {
        try {
            $rental->status = 2;
            $rental->save();

            $data = [
                'status' => 200,
                'rental' => $rental,
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($e, 401);
        }
    }
}
