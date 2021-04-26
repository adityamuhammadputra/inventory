<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Vendor;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index(Request $request)
    {
        logActivities('View Operator page');

        $data = (object) [
            'model' => 'OP',
            'vendor' => Vendor::get(),
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
