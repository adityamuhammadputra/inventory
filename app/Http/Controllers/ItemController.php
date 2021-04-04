<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Merk;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $data = (object) [
            'maxKode' => Barang::maxKode('IP'),
            'kategori' => 'IP',
        ];

        return view('barang.index', compact('data'));
    }

    public function create()
    {

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

}
