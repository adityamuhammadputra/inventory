<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
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
