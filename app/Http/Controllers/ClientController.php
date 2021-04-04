<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $data = (object) [
            'model' => 'CL',
        ];

        return view('jasa.client.index', compact('data'));
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
