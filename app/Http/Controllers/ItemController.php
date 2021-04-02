<?php

namespace App\Http\Controllers;

use App\Merk;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $data = (object) [
            'merk' => Merk::pluck('nama', 'id')
        ];

        return view('item.index', compact('data'));
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
