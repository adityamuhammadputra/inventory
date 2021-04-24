<?php

namespace App\Http\Controllers;

use App\Barang;
use App\BarangLog;
use App\Event;
use App\EventBarang;
use App\EventBarangItem;
use App\EventOperator;
use App\Operator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpWord\TemplateProcessor;


class EventController extends Controller
{

    public function index(Request $request)
    {

        $data = (object) [
            'noReg' => getMaxEvent(),
            'dateNow' => Carbon::now()->format('d F Y'),
            'dateTom' => Carbon::now()->addDays(1)->format('d F Y'),
            'method' => 'POST',
            'action' => "/event",
            'event' => null,
        ];

        return view('event.index', compact('data'));
    }

    public function inputBarang($request, $eventDb)
    {
        $idEventBarang = [];
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
                $idEventBarang [$key] = [$key => $uuid];
                $barangs [] = [
                    'id' => $uuid,
                    'event_id' => $eventDb->id,
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
                    'event_id' => $eventDb->id,
                    'barang_kode' => $barangDb->kode,
                    'start' => dateInput($eventDb->date_start),
                    'end' => dateInput($eventDb->date_end),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];

            endforeach;
            EventBarang::insert($barangs);
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
                            'event_barang_id' => $idEventBarang[$key][$key],
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
                            'event_id' => $eventDb->id,
                            'barang_kode' => $barangDb->kode,
                            'start' => dateInput($eventDb->date_start),
                            'end' => dateInput($eventDb->date_end),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];

                    endif;
                endforeach;
            endforeach;
            EventBarangItem::insert($items);
            BarangLog::insert($barangLogs);
        endif;
    }


    public function inputOperator($request, $eventDb)
    {
        if($request->op) :
            $ops = [];
            foreach($request->op as $subKeyOp => $subOp) :
                if(!$request->op[$subKeyOp] == null) :
                    $opDb = Operator::where('kode', explode(' - ', $subOp)[1])->first();
                    $op_id = $opDb->id;
                    $op_name = $opDb->nama;
                    $op_tugas = $opDb->tugas;
                    $op_temp = inputRupiah($opDb->harga);
                    $op_harga = inputRupiah($opDb->harga);
                    // $op_harga = inputRupiah($request->priceOp[$subKeyOp]);
                    $uuid = uuid();
                    $ops [] = [
                        'id' => $uuid,
                        'event_id' => $eventDb->id,
                        'operator_id' => $op_id,
                        'operator_nama' => $op_name,
                        'operator_tugas' => $op_tugas,
                        'operator_temp' => $op_temp,
                        'operator_harga' => $op_harga,
                        'operator_qty' => $request->dayOp[$subKeyOp],
                        'operator_total' => inputRupiah($request->priceOp[$subKeyOp]),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                endif;
            endforeach;
            EventOperator::insert($ops);
        endif;
    }


    public function store(Request $request)
    {
        $event = $request->only('noreg', 'vendor_name', 'client_name', 'name', 'location', 'diskon', 'time_start', 'time_end');
        $event['id'] = uuid();
        $event['date_start'] = dateInput($request->date_start);
        $event['date_end'] = dateInput($request->date_end);
        $event['sub_total_op'] = inputRupiah($request->sub_total_op);
        $event['sub_total'] = inputRupiah($request->sub_total);
        $event['diskon'] = $request->diskon ?? 0;
        $event['total'] = inputRupiah($request->total);
        $event['user_id'] = userId();
        $event['status'] = 1;
        try {
            DB::beginTransaction();
                $eventDb = Event::create($event);
                $this->inputBarang($request, $eventDb);
                $this->inputOperator($request, $eventDb);
                $status = 200;
            DB::commit();
        } catch (\Throwable $th) {
            report($th);
            $status = 401;
        }

        $data = [
            'noReg' => getMaxEvent(),
            'status' => $status,
        ];

        return response()->json($data, $status);
    }

    public function edit($id)
    {
        $event = Event::with('eventOperator', 'eventBarangs')
                        ->findOrFail($id);

        $data = (object) [
            'noReg' => $event->noreg,
            'dateNow' => $event->date_start,
            'dateTom' => $event->date_end,
            'method' => 'PATCH',
            'action' => "/event/$event->id",
            'event' => $event,
        ];

        return view('event.edit', compact('data'));
    }

    public function update(Request $request, Event $event)
    {
        $inputEvent = $request->only('noreg', 'vendor_name', 'client_name', 'name', 'location', 'diskon', 'time_start', 'time_end');
        $inputEvent['date_start'] = dateInput($request->date_start);
        $inputEvent['date_end'] = dateInput($request->date_end);
        $inputEvent['sub_total_op'] = inputRupiah($request->sub_total_op);
        $inputEvent['sub_total'] = inputRupiah($request->sub_total);
        $inputEvent['diskon'] = $request->diskon ?? 0;
        $inputEvent['total'] = inputRupiah($request->total);
        $inputEvent['user_id'] = userId();
        $inputEvent['status'] = 1;

        try {
            DB::beginTransaction();
                BarangLog::where('event_id', $event->id)
                    ->where('start', dateInput($event->date_start))
                    ->where('end', dateInput($event->date_end))
                    ->delete();

                $event->update($inputEvent);
                EventBarang::where('event_id', $event->id)->delete();
                EventBarangItem::where('event_barang_id', $event->id)->delete();
                EventOperator::where('event_id', $event->id)->delete();


                $this->inputBarang($request, $event);
                $this->inputOperator($request, $event);



            DB::commit();
            $status = 200;
        } catch (\Throwable $th) {
            report($th);
            $status = 401;
        }

        $data = [
            'noReg' => getMaxEvent(),
            'status' => $status,
            'url' => '/event',
        ];

        return response()->json($data, $status);

    }

    public function show($id)
    {
        $event = Event::with('eventOperator', 'eventBarangs')
                        ->findOrFail($id);
        return $event;
    }

    public function destroy(Event $event)
    {
        BarangLog::where('event_id', $event->id)
                    ->where('start', dateInput($event->date_start))
                    ->where('end', dateInput($event->date_end))
                    ->delete();

        return $event->delete();
    }

    public function approve(Request $request, Event $event)
    {
        try {
            $event->status = 2;
            $event->save();
            BarangLog::where('event_id', $event->id)
                    ->where('start', dateInput($event->date_start))
                    ->where('end', dateInput($event->date_end))
                    ->update([
                        'deleted_at' => Carbon::now()
                    ]);

            $data = [
                'status' => 200,
                'event' => $event,
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($e, 401);
        }
    }


    public function letter(Event $event)
    {
        $templateProcessor = new TemplateProcessor('word/event-letter.docx');
        $templateProcessor->setValues([
            'vendor' => "$event->vendor_name",
            'client' => "$event->client_name",
            'eventName' => "$event->name",
            'eventLocation' => "$event->location",
            'start' => "$event->date_start $event->time_start",
            'end' => "$event->date_end $event->time_end",
        ]);

        $noOp = 1;
        $templateProcessor->cloneRow('noOp', count($event->eventOperator));
        foreach($event->eventOperator as $valOp) :
            $templateProcessor->setValue("noOp#$noOp", $noOp);
            $templateProcessor->setValue("operatorJobs#$noOp", $valOp->operator_tugas);
            $templateProcessor->setValue("operatorName#$noOp", $valOp->operator_nama);
            $noOp++;
        endforeach;

        $no = 1;
        $templateProcessor->cloneRow('no', count($event->eventBarangs));
        foreach($event->eventBarangs as $val) :
            $templateProcessor->setValue("no#$no", $no);
            $templateProcessor->setValue("equipmentName#$no", $val->barang_name);
            $templateProcessor->setValue("equipmentSn#$no", $val->barang->serial_number);
            $templateProcessor->setValue("items#$no", $val->items);
            $no++;
        endforeach;

        header("Content-Disposition: attachment; filename=letter-$event->noreg.docx");

        $templateProcessor->saveAs('php://output');
    }

    public function operatorDocx(Event $event)
    {
        $templateProcessor = new TemplateProcessor('word/event-operator-inv.docx');
        $templateProcessor->setValues([
            'vendor' => "$event->vendor_name",
            'client' => "$event->client_name",
            'eventName' => "$event->name",
            'eventLocation' => "$event->location",
            'start' => "$event->date_start $event->time_start",
            'end' => "$event->date_end $event->time_end",
            'total' => "$event->sub_total_op"
        ]);

        $noOp = 1;
        $templateProcessor->cloneRow('no', count($event->eventOperator));
        foreach($event->eventOperator as $valOp) :
            $templateProcessor->setValue("no#$noOp", $noOp);
            $templateProcessor->setValue("name#$noOp", $valOp->operator_nama);
            $templateProcessor->setValue("job#$noOp", $valOp->operator_tugas);
            $templateProcessor->setValue("price#$noOp", outputRupiah($valOp->operator_harga));
            $templateProcessor->setValue("day#$noOp", $valOp->operator_qty);
            $templateProcessor->setValue("amount#$noOp", $valOp->operator_total);
            $noOp++;
        endforeach;

        header("Content-Disposition: attachment; filename=payment-receipt-operator-$event->noreg.docx");

        $templateProcessor->saveAs('php://output');
    }


    public function invoice(Event $event)
    {
        $templateProcessor = new TemplateProcessor('word/event-inv.docx');
        $templateProcessor->setValues([
            'invNo' => "$event->noreg",
            'date' => "$event->create_at",
            'vendor' => "$event->vendor_name",
            'client' => "$event->client_name",
            'eventName' => "$event->name",
            'eventLocation' => "$event->location",
            'start' => "$event->date_start $event->time_start",
            'end' => "$event->date_end $event->time_end",
            'subTotalOp' => $event->sub_total_op,
            'subTotal' => $event->sub_total,
            'sub_total_all' => $event->sub_total_all,
            'diskon' => "$event->diskon%",
            'total' => "$event->total"
        ]);

        $noOp = 1;
        $templateProcessor->cloneRow('noOp', count($event->eventOperator));
        foreach($event->eventOperator as $valOp) :
            $templateProcessor->setValue("noOp#$noOp", $noOp);
            $templateProcessor->setValue("operatorJobs#$noOp", $valOp->operator_tugas);
            $templateProcessor->setValue("operatorName#$noOp", $valOp->operator_nama);
            $templateProcessor->setValue("hargaOp#$noOp", $valOp->operator_harga);
            $templateProcessor->setValue("dayOp#$noOp", $valOp->operator_qty);
            $templateProcessor->setValue("priceOp#$noOp", $valOp->operator_total);
            $noOp++;
        endforeach;

        $no = 1;
        $templateProcessor->cloneRow('no', count($event->eventBarangs));
        foreach($event->eventBarangs as $val) :
            $templateProcessor->setValue("no#$no", $no);
            $templateProcessor->setValue("equipmentName#$no", $val->barang_name);
            $templateProcessor->setValue("equipmentSn#$no", $val->barang->serial_number);
            $templateProcessor->setValue("items#$no", $val->items);
            $templateProcessor->setValue("harga#$no", '-');
            $templateProcessor->setValue("day#$no", $val->barang_qty);
            $templateProcessor->setValue("price#$no", outputRupiah($val->barang_item_total));
            $no++;
        endforeach;

        header("Content-Disposition: attachment; filename=inv-$event->noreg.docx");

        $templateProcessor->saveAs('php://output');
    }



    public function dataTable(Request $request)
    {
        $event = Event::with('eventBarangs')->filtered();

        return DataTables::of($event)
            ->addColumn('action', function ($data) {
                $action= '';
                if($data->status == 1) {
                    $action = '<a data-id="'.$data->id.'"
                                    data-title="Event  #' . $data->noreg . '"
                                    data-url="/event/'.$data->id.'/approve"
                                    class="text-warning approveData"><i class="fa fa-check"></i>
                                </a>

                                <a data-id="' . $data->id . '"
                                    data-title="' . $data->kode . '"
                                    data-url="/event/'.$data->id.'"
                                    class="text-danger deleteData"><i class="fa fa-trash"></i>
                                </a>';
                }
                return'<a href="/event/'.$data->id.'/edit"
                            class="text-primary"><i class="fa fa-info-circle"></i>
                        </a>' . $action;
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
