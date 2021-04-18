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
use PhpOffice\PhpWord\TemplateProcessor;
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
        $rental = $request->only('noreg', 'nama', 'kontak', 'alamat', 'diskon');
        $rental['id'] = uuid();
        $rental['diskon'] = $request->diskon ?? 0;
        $rental['start'] = dateInput($request->start);
        $rental['end'] = dateInput($request->end);
        $rental['sub_total'] = inputRupiah($request->sub_total);
        $rental['total'] = inputRupiah($request->total);
        $rental['user_id'] = userId();
        $rental['status'] = 1;

        DB::beginTransaction();
            $rentalDb = Rental::create($rental);
            $this->inputBarang($request, $rentalDb);
        DB::commit();

        $data = [
            'noReg' => getMaxRental(),
            'status' => 200,
            'url' => null,
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, Rental $rental)
    {
        $inputRental = $request->only('noreg', 'nama', 'kontak', 'alamat', 'diskon');
        $inputRental['diskon'] = $request->diskon ?? 0;
        $inputRental['start'] = dateInput($request->start);
        $inputRental['end'] = dateInput($request->end);
        $inputRental['sub_total'] = inputRupiah($request->sub_total);
        $inputRental['total'] = inputRupiah($request->total);
        $inputRental['user_id'] = userId();
        $inputRental['status'] = 1;

        DB::beginTransaction();
            $rental->update($inputRental);
            RentalBarang::where('rental_id', $rental->id)->delete();
            RentalBarangItem::where('rental_barang_id', $rental->id)->delete();
            $this->inputBarang($request, $rental);
        DB::commit();

        $data = [
            'noReg' => getMaxRental(),
            'status' => 200,
            'url' => '/rental',
        ];

        return response()->json($data, 200);
    }

    public function inputBarang($request, $rentalDb)
    {
        $idRentalBarang = [];
        if($request->equpment) :
            $barangs = [];
            foreach($request->equpment as $key => $barang) :
                $barangDb = Barang::where('kode', explode(' - ', $barang)[0])->first();
                $barang_id = $barangDb->id;
                $barang_name = $barangDb->jenis . ' - ' .$barangDb->merk . ' - ' .$barangDb->type;
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
                    'barang_qty' => $request->day[$key],
                    'barang_total' => $barang_harga * $request->day[$key],
                    'barang_item_total' => inputRupiah($request->price[$key]),
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
                        $barang_name = $barangDb->jenis . ' - ' .$barangDb->merk . ' - ' .$barangDb->type;
                        $barang_temp = inputRupiah($barangDb->harga);
                        $barang_harga = inputRupiah(explode(' - ', $subItem)[2]);
                        $items [] = [
                            'id' => uuid(),
                            'rental_barang_id' => $idRentalBarang[$key][$key],
                            'barang_id' => $barang_id,
                            'barang_name' => $barang_name,
                            'barang_temp' => $barang_temp,
                            'barang_harga' => $barang_harga,
                            'barang_qty' => $request->day[$key],
                            'barang_total' => $barang_harga * $request->day[$key],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];
                    endif;
                endforeach;
            endforeach;
            RentalBarangItem::insert($items);
        endif;
    }


    public function dataTable(Request $request)
    {
        $rental = Rental::with('rentalBarangs')->filtered();

        return DataTables::of($rental)
            ->addColumn('action', function ($data) {
                $approve = '';
                if($data->status == 1)
                    $approve = '<a data-id="'.$data->id.'"
                                data-title="Rental #' . $data->noreg . '"
                                data-url="/rental/'.$data->id.'/approve"
                                class="text-primary approveData"><i class="fa fa-check"></i>
                            </a>';
                return $approve .
                        '<a href="/rental/'.$data->id.'/edit"
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

    public function letter(Rental $rental)
    {
        $templateProcessor = new TemplateProcessor('word/rental-letter.docx');
        $templateProcessor->setValues([
            'name' => "$rental->nama",
            'no_hp' => "$rental->kontak",
            'alamat' => "$rental->alamat",
            'start' => "$rental->start",
            'end' => "$rental->end",
        ]);

        $values = [];
        $no = 1;
        foreach($rental->rentalBarangs as $key => $val) :
            $values [] = [
                    'no' => $no++,
                    'equipmentName' => $val->barang_name,
                    'equipmentSn' => $val->barang->serial_number,
            ];
        endforeach;

        $templateProcessor->cloneRowAndSetValues('no', $values);

        header("Content-Disposition: attachment; filename=letter$rental->noreg-$rental->id.docx");

        $templateProcessor->saveAs('php://output');
    }


    public function invoice(Rental $rental)
    {
        $templateProcessor = new TemplateProcessor('word/rental-inv.docx');
        $templateProcessor->setValues([
            'invNo' => "#$rental->noreg",
            'date' => "$rental->created_at",
            'name' => "$rental->nama",
            'no_hp' => "$rental->kontak",
            'alamat' => "$rental->alamat",
            'start' => "$rental->start",
            'end' => "$rental->end",
            'sub_total' => "$rental->sub_total",
            'diskon' => "$rental->diskon %",
            'total' => "$rental->total",
        ]);

        $values = [];
        $no = 1;
        foreach($rental->rentalBarangs as $key => $val) :
            $values [] = [
                    'no' => $no++,
                    'equipmentName' => $val->barang_name,
                    'equipmentPrice' => outputRupiah($val->barang_harga),
                    'equipmentDay' => $val->barang_qty,
                    'equipmentTotal' => outputRupiah($val->barang_total),
            ];
        endforeach;

        $templateProcessor->cloneRowAndSetValues('no', $values);

        header("Content-Disposition: attachment; filename=inv$rental->noreg-$rental->id.docx");

        $templateProcessor->saveAs('php://output');
    }
}
