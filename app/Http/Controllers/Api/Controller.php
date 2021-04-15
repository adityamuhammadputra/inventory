<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\Client;
use App\Operator;
use App\Rental;
use App\Vendor;
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
}
