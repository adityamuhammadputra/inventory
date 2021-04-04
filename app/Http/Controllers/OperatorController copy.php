<?php

namespace App\Http\Controllers;

use App\Barang;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index(Request $request)
    {
        $data = (object) [
            'model' => 'Operator',
        ];

        return view('jasa.operator.index', compact('data'));
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
