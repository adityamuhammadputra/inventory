<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Client;
use App\Event;
use App\EventBarang;
use App\EventBarangItem;
use App\EventOperator;
use App\Operator;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{

    public function index(Request $request)
    {

        $data = (object) [
            'noReg' => getMaxEvent(),
            'dateNow' => Carbon::now()->format('d F Y'),
            'method' => 'POST',
            'action' => "/event",
            'event' => null,
        ];

        return view('event.index', compact('data'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
            $event = $request->only('noreg', 'vendor_name', 'client_name', 'name', 'location', 'diskon', 'time');
            $event['id'] = uuid();
            $event['date'] = dateInput($request->date);
            $event['sub_total_op'] = inputRupiah($request->sub_total_op);
            $event['sub_total'] = inputRupiah($request->sub_total);
            $event['total'] = inputRupiah($request->total);
            $event['user_id'] = userId();
            $event['status'] = 1;
            $eventDb = Event::create($event);

            // $idEventOper = [];
            if($request->op) :
                $ops = [];
                foreach($request->op as $keyOp => $op) :
                    foreach($op as $subKeyOp => $subOp) :
                        if(!$request->op[$keyOp][$subKeyOp] == null) :
                            $opDb = Operator::where('kode', explode(' - ', $subOp)[0])->first();
                            $op_id = $opDb->id;
                            $op_name = $opDb->nama;
                            $op_tugas = $request->opTugas[$keyOp];
                            $op_temp = inputRupiah($opDb->harga);
                            $op_harga = inputRupiah($request->priceOp[$keyOp]);
                            $uuid = uuid();
                            $ops [] = [
                                'id' => $uuid,
                                'event_id' => $eventDb->id,
                                'operator_id' => $op_id,
                                'operator_nama' => $op_name,
                                'operator_tugas' => $op_tugas,
                                'operator_temp' => $op_temp,
                                'operator_harga' => $op_harga,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ];
                        endif;
                    endforeach;
                endforeach;
                EventOperator::insert($ops);
            endif;

            $idEventOperator = [];
            if($request->equpment) :
                $barangs = [];
                foreach($request->equpment as $key => $barang) :
                    $barangDb = Barang::where('kode', explode(' - ', $barang)[0])->first();
                    $barang_id = $barangDb->id;
                    $barang_name = $barangDb->merk;
                    $barang_temp = inputRupiah($barangDb->harga);
                    $barang_harga = inputRupiah(explode(' - ', $barang)[2]);
                    $uuid = uuid();
                    $idEventOperator [$key] = [$key => $uuid];
                    $barangs [] = [
                        'id' => $uuid,
                        'event_id' => $eventDb->id,
                        'barang_id' => $barang_id,
                        'barang_name' => $barang_name,
                        'barang_temp' => $barang_temp,
                        'barang_harga' => $barang_harga,
                        'barang_total' => inputRupiah($request->price[$key]),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                endforeach;
                EventBarang::insert($barangs);
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
                                'event_barang_id' => $idEventOperator[$key][$key],
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
                EventBarangItem::insert($items);
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
                $objWriter->save(storage_path("app/inv/{$eventDb->id}.docx"));
            } catch (Exception $e) {
                dd($e);
            }
            // return response()->download(storage_path("app/inv/{$eventDb->id}.docx"));
        DB::commit();

        $data = [
            'noReg' => getMaxEvent(),
            'status' => 200,
        ];

        return response()->json($data, 200);
    }

    public function edit($id)
    {
        $event = Event::with('eventOperator', 'eventBarangs')
                        ->findOrFail($id);

        $data = (object) [
            'noReg' => $event->noreg,
            'dateNow' => $event->date,
            'method' => 'PATCH',
            'action' => "/event/$event->id",
            'event' => $event,
        ];

        return view('event.edit', compact('data'));
    }

    public function show($id)
    {
        $event = Event::with('eventOperator', 'eventBarangs')
                        ->findOrFail($id);
        return $event;
    }


    public function dataTable(Request $request)
    {
        $event = Event::with('eventBarangs')->filtered();

        return DataTables::of($event)
            ->addColumn('action', function ($data) {
                return '<a href="'.$data->id.'" target="_blank"
                            class="text-primary"><i class="fa fa-print"></i>
                        </a>
                        <a href="/event/'.$data->id.'/edit"
                            class="text-info"><i class="fa fa-info-circle"></i>
                        </a>
                        <a data-id="' . $data->id . '"
                            data-title="' . $data->kode . '"
                            data-url="/api/v1/barang/'.$data->id.'"
                            class="text-danger deleteData"><i class="fa fa-trash"></i>
                        </a>';
            })
            ->addColumn('count_op', function ($data) {
                return $data->eventOperator->count();
            })
            ->addColumn('count_equipment', function ($data) {
                return $data->eventBarangs->count();
            })
            ->addColumn('count_item', function ($data) {
                return $data->eventBarangs->sum('count_item');
            })
            ->rawColumns(['action', 'count_equipment', 'count_item'])
            ->make(true);
    }
}
