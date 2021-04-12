<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use App\Client;
use App\Rental;
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

                'data' => $c->id,
                'value' => "$c->nama - $c->kontak",
            ];
        endforeach;

        $result = ['suggestions' => $data];

        return response()->json($result, 200);
    }
}
