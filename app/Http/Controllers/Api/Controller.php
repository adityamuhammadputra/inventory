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
            $barang = Barang::item()->filtered()->get();
        else
            $barang = Barang::equipment()->filtered()->get();

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
        $event = Event::select('date_start as start', 'date_end as end', 'sub_total', 'sub_total_op')
                    ->where('date_start', '>=', $start)
                    ->where('date_end', '<=', $end)
                    ->get()
                    ->toArray();

        $rental = Rental::select('start', 'end', 'sub_total as sub_total', 'total as sub_total_op')
                    ->where('start', '>=', $start)
                    ->where('end', '<=', $end)
                    ->get()
                    ->toArray();

        $results = array_merge($event,$rental);

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
            // for ($i = 0; $i < $d['n']; $i++) {
            $results[] = [
                'title' => $d['n'],
                'color' => 'danger',
                'start' => $d['date'],
                'end' => date('Y-m-d', strtotime($d['date'] . '+' . 1 . 'days')),
                'backgroundColor' => '#ffe2bc',
                'borderColor' => "#ffe2bc",
            ];
            // }
        }
        return json_encode($results);

    }
}
