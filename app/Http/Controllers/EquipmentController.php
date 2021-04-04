<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Merk;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $data = (object) [
            'maxKode' => Barang::maxKode('EP'),
            'kategori' => 'EP',
            'title' => 'Data Equipment'
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
