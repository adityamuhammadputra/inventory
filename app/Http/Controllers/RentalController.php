<?php

namespace App\Http\Controllers;

use App\Barang;
use App\BarangLog;
use App\Client;
use App\Export\ExportRental;
use App\Rental;
use App\RentalBarang;
use App\RentalBarangItem;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class RentalController extends Controller
{

    public function index(Request $request)
    {
        if($request->export) :
            $events = Rental::filtered()->get();
            $data = (object) [
                'data' => $events,
                'attr' => (object) [
                    'dateStart' => $request->date_start ?? Rental::where('status', 2)->orderBy('created_at', 'asc')->first()->start,
                    'dateEnd' => $request->date_end ?? Rental::where('status', 2)->orderBy('created_at', 'desc')->first()->end,
                    'total' => ($request->total) ? " | Total > $request->total" : "",
                    'title' => ($request->aproved) ? 'Has Approved' : 'Not Approved',
                ]
            ];

            $name = ($request->aproved) ? 'has-approved' : 'not-approved';
            logActivities("Export Rental rental-$name.xlsx");
            return Excel::download(new ExportRental($data), "rental-$name.xlsx");

        endif;

        $data = (object) [
            'noReg' => getMaxRental(),
            'dateNow' => Carbon::now()->format('d F Y'),
            'method' => 'POST',
            'action' => "/rental",
            'event' => null,
        ];

        logActivities("View Rental page");
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
            logActivities("Create Rental $rentalDb->id");
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
            BarangLog::where('rental_id', $rental->id)
                ->where('start', dateInput($rental->start))
                ->where('end', dateInput($rental->end))
                ->delete();

            $rental->update($inputRental);
            logActivities("Update Rental $rental->id");
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
            $barangLogs = [];
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

                $barangLogs [] = [
                    'id' => uuid(),
                    'rental_id' => $rentalDb->id,
                    'barang_kode' => $barangDb->kode,
                    'start' => dateInput($rentalDb->start),
                    'end' => dateInput($rentalDb->end),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];

            endforeach;
            RentalBarang::insert($barangs);
            BarangLog::insert($barangLogs);

        endif;

        if($request->item) :
            $items = [];
            $barangLogs = [];

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

                        $barangLogs [] = [
                            'id' => uuid(),
                            'rental_id' => $rentalDb->id,
                            'barang_kode' => $barangDb->kode,
                            'start' => dateInput($rentalDb->start),
                            'end' => dateInput($rentalDb->end),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];

                    endif;
                endforeach;
            endforeach;
            RentalBarangItem::insert($items);
            BarangLog::insert($barangLogs);
        endif;
    }


    public function dataTable(Request $request)
    {
        $rental = Rental::with('rentalBarangs')->filtered();

        return DataTables::of($rental)
            ->addColumn('action', function ($data) {
                $approve = '';
                $deleted = '';
                if($data->status == 1){
                    $approve = '<a data-id="'.$data->id.'"
                                    data-title="Rental #' . $data->noreg . '"
                                    data-url="/rental/'.$data->id.'/approve"
                                    class="text-warning approveData"><i class="fa fa-check"></i>
                                </a>';

                    $deleted =  '<a data-id="' . $data->id . '"
                                    data-title="' . $data->kode . '"
                                    data-url="/rental/'.$data->id.'"
                                    class="text-danger deleteData"><i class="fa fa-trash"></i>
                                </a>';
                }

                return '<a href="/rental/'.$data->id.'/edit"
                            class="text-primary"><i class="fa fa-info-circle"></i>
                        </a>'
                        .$approve . $deleted;
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
        BarangLog::where('rental_id', $rental->id)
                    ->where('start', dateInput($rental->start))
                    ->where('end', dateInput($rental->end))
                    ->delete();

        logActivities("Delete Rental $rental->id");

        return $rental->delete();
    }

    public function approve(Request $request, Rental $rental)
    {
        try {
            $rental->status = 2;
            $rental->save();

            BarangLog::where('rental_id', $rental->id)
                    ->where('start', dateInput($rental->start))
                    ->where('end', dateInput($rental->end))
                    ->update([
                        'deleted_at' => Carbon::now()
                    ]);


            $data = [
                'status' => 200,
                'rental' => $rental,
            ];

            logActivities("Approve Rental $rental->id");
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
        $templateProcessor->cloneRow('no', count($rental->rentalBarangs));
        foreach($rental->rentalBarangs as $val) :

            $templateProcessor->setValue("no#$no", $no);
            $templateProcessor->setValue("equipmentName#$no", $val->barang_name);
            $templateProcessor->setValue("equipmentSn#$no", $val->barang->serial_number);
            $templateProcessor->setValue("items#$no", $val->items);
            $no++;
        endforeach;

        // foreach($rental->rentalBarangs as $key => $val) :
        //     $values [] = [
        //             'no' => $no++,
        //             'equipmentName' => $val->barang_name,
        //             'equipmentSn' => $val->barang->serial_number,
        //             'items#1' => 'x',
        //         ];
        // endforeach;

        // $templateProcessor->cloneRowAndSetValues('no', $values);

        logActivities("Export docx Rental letter-$rental->noreg");

        header("Content-Disposition: attachment; filename=letter-$rental->noreg.docx");

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

            foreach($val->rentalBarangItems as $barang) :
                $barang = [
                    'no' => $no++,
                    'equipmentName' => $barang->barang_name,
                    'equipmentPrice' => outputRupiah($barang->barang_harga),
                    'equipmentDay' => $barang->barang_qty,
                    'equipmentTotal' => outputRupiah($barang->barang_total),
                ];
                array_push($values, $barang);
            endforeach;
        endforeach;


        $templateProcessor->cloneRowAndSetValues('no', $values);

        logActivities("Export docx Rental inv-$rental->noreg");
        header("Content-Disposition: attachment; filename=inv-$rental->noreg.docx");

        $templateProcessor->saveAs('php://output');
    }
}
