<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DNS1D;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        Storage::disk('public')->put('test.png',base64_decode(DNS1D::getBarcodePNG("4445645656", "C128")));
        return DNS1D::getBarcodeSVG('4445645656', 'C128');
        return '<img src="data:image/png,' . DNS1D::getBarcodeHTML('4445645656', 'C128') . '" alt="barcode"/>';
        return view('item.index');
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
