<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RentalController extends Controller
{

    protected $noReg;
    public function index(Request $request)
    {
        $this->noReg = 'RE00001';

        $data = (object) [
            'noReg' => $this->noReg
        ];

        return view('rental.index', compact('data'));
    }
}
