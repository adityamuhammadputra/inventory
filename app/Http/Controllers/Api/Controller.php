<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\Client;
use App\Event;
use App\Operator;
use App\Rental;
use App\Vendor;
use Carbon\CarbonPeriod;
use DateTime;
use Exception;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function generateBarcode($kode)
    {
        try {
            generateBarcode($kode);
            $data = [
                'status' => 200,
                'path' => "/img/barcode/$kode.svg",
            ];

        } catch (Exception $e) {
            $data = $e;
        }

        return response($data);
    }

    public function checkVisibleBarang()
    {
        $barang = Barang::checkBarang()->first();
        return response($barang);
    }

    public function checkVisibleNoreg()
    {
        return response(Rental::checkNoreg()->first());
    }

    public function lookupClient(Request $request)
    {
        $client = Client::filtered()->get();
        $data = [];
        foreach($client as $c) :
            $data [] = [

                'data' => $c,
                'value' => "$c->nama",
            ];
        endforeach;

        $result = ['suggestions' => $data];

        return response()->json($result, 200);
    }

    public function lookupVendor(Request $request)
    {
        $vendor = Vendor::filtered()->get();
        $data = [];
        foreach($vendor as $v) :
            $data [] = [

                'data' => $v,
                'value' => "$v->nama",
            ];
        endforeach;

        $result = ['suggestions' => $data];

        return response()->json($result, 200);
    }

    public function lookupBarang(Request $request)
    {
        if($request->kategori == 'IP')
            $barang = Barang::item()->available()->filtered()->get();
        else
            $barang = Barang::equipment()->available()->filtered()->get();
        $data = [];
        foreach($barang as $c) :
            $data [] = [
                'data' => $c,
                // 'value' => "$c->kode - $c->jenis - $c->harga",
                'value' => "$c->kode",
            ];
        endforeach;

        $result = ['suggestions' => $data];

        return response()->json($result, 200);
    }

    public function lookupOperator(Request $request)
    {
        $operator = Operator::filtered()->get();

        $data = [];
        foreach($operator as $c) :
            $data [] = [
                'data' => $c,
                'value' => "$c->nama - $c->tugas",
            ];
        endforeach;

        $result = ['suggestions' => $data];

        return response()->json($result, 200);
    }

    public function lookupCalendar(Request $request)
    {
        $start = $request->start ? new DateTime($request->start) : (new DateTime())->modify('first day of this month');
        $end = $request->end ? new DateTime($request->end) : (new DateTime())->modify('last day of this month');
        $resultsEvent = Event::select('date_start as start', 'date_end as end', 'sub_total', 'sub_total_op')
                    ->where('date_start', '>=', $start)
                    ->where('date_end', '<=', $end)
                    ->where('status', 1)
                    ->get();


        $bulanEvent = collect([]);
        foreach ($resultsEvent as $k) {
            $x = collect(CarbonPeriod::create($k['start'], $k['end']));
            // $color = "{$k['color']}";
            $color = "";
            $x = $x->map(function ($item, $_) use($color) {
                return [
                    'date' => $item->format('Y-m-d'),
                    // 'color' => $color,
                ];
            });
            $bulanEvent = $bulanEvent->merge($x);
        }

        $resultEvent = $bulanEvent->groupBy('date')->map(function ($item,  $_) {
            return [
                'date' => $item[0]['date'],
                'n' => count($item),
                // 'color' => $item[0]['color'],
            ];
        });

        $resultsEvent = [];
        foreach ($resultEvent as $d) {
            $resultsEvent[] = [
                'title' => "{$d['n']}",
                'color' => 'blue',
                'right' => 14,
                'top' => -54,
                'start' => $d['date'],
                'end' => date('Y-m-d', strtotime($d['date'] . '+' . 1 . 'days')),
                'backgroundColor' => '#ffe2bc',
                'borderColor' => "#ffe2bc",
            ];

        }


        $resultsRental = Rental::select('start', 'end', 'sub_total as sub_total', 'total as sub_total_op')
                    ->where('start', '>=', $start)
                    ->where('end', '<=', $end)
                    ->where('status', 1)
                    ->get();

        $bulanRental = collect([]);
        foreach ($resultsRental as $k) {
            $x = collect(CarbonPeriod::create($k['start'], $k['end']));
            $color = $k['color'];
            $x = $x->map(function ($item, $_) use($color) {
                return [
                    'date' => $item->format('Y-m-d'),
                ];
            });
            $bulanRental = $bulanRental->merge($x);
        }

        $resultRental = $bulanRental->groupBy('date')->map(function ($item,  $_) {
            return [
                'date' => $item[0]['date'],
                'n' => count($item),
            ];
        });

        $resultsRental = [];
        foreach ($resultRental as $d) {
            $resultsRental[] = [
                'title' => "{$d['n']}",
                'color' => '#f98c01',
                'right' => 20,
                'top' => -56,
                'start' => $d['date'],
                'end' => date('Y-m-d', strtotime($d['date'] . '+' . 1 . 'days')),
                'backgroundColor' => '#ffe2bc',
                'borderColor' => "#ffe2bc",
            ];
        }

        $rental = Rental::select('start', 'end', 'sub_total as sub_total', 'total as sub_total_op')
                    ->where('start', '>=', $start)
                    ->where('end', '<=', $end)
                    ->where('status', 2)
                    ->get()->toArray();

        $event = Event::select('date_start as start', 'date_end as end', 'sub_total', 'sub_total_op')
                    ->where('date_start', '>=', $start)
                    ->where('date_end', '<=', $end)
                    ->where('status', 2)
                    ->get()->toArray();

        $results = array_merge($event, $rental);
        $bulan = collect([]);
        foreach ($results as $k) {
            $x = collect(CarbonPeriod::create($k['start'], $k['end']));
            $x = $x->map(function ($item, $_) {
                return [
                    'date' => $item->format('Y-m-d'),
                ];
            });
            $bulan = $bulan->merge($x);
        }

        $result = $bulan->groupBy('date')->map(function ($item,  $_) {
            return [
                'date' => $item[0]['date'],
                'n' => count($item),
            ];
        });

        $results = [];
        foreach ($result as $d) {
            $results[] = [
                'title' => "{$d['n']}",
                'color' => '#d0d0d0',
                'right' => 14,
                'top' => -44,
                'start' => $d['date'],
                'end' => date('Y-m-d', strtotime($d['date'] . '+' . 1 . 'days')),
                'backgroundColor' => '#ffe2bc',
                'borderColor' => "#ffe2bc",
            ];
        }

        $result = array_merge($resultsEvent, $resultsRental);
        $resultAll = array_merge($results, $result);
        return json_encode($resultAll);
    }


    public function showLookupCalendar($date)
    {
        $rental = Rental::select('id', 'noreg', 'nama as name', 'start', 'end', 'alamat as location', 'total as sub_total', 'total as sub_total_op', 'total', 'status')
                        ->whereDate('start', '<=', $date)
                        ->whereDate('end', '>=', $date)
                        ->get();

        $event = Event::select('id', 'noreg', 'name', 'date_start as start', 'date_end as end', 'location', 'sub_total', 'sub_total_op', 'total', 'status')
                        ->whereDate('date_start','<=', $date)
                        ->whereDate('date_end', '>=', $date)
                        ->get();

        $merged = $rental->merge($event);

        $result = $merged->all();

        $results = [];
        foreach($result as $result) :
            $results [] = [
                'id' => $result->id,
                'noreg' => $result->noreg,
                'name' => $result->name,
                'start' => ($result->jenis == 'Event') ? dateOutput($result->start) : $result->start,
                'end' => ($result->jenis == 'Event') ? dateOutput($result->end) : $result->end,
                'location' => $result->location,
                'total' => $result->total,
                'status' => $result->status,
                'jenis' => $result->jenis,
                'items' => $result->items,
                'url' => ($result->jenis == 'Event') ? "/event/{$result->id}/edit" : "/rental/{$result->id}/edit"
            ];
        endforeach;

        $data = (object) [
            'timeline' => json_decode(json_encode($results), FALSE),
        ];

        return view('dashboard._timeline', compact('data'));
    }
}
