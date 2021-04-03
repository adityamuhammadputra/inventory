<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function dataTable()
    {
        $data = Barang::item()->filtered();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<a href="'.$data->barcode.'" target="_blank"
                            class="btn btn-outline-info text-info"><i class="fa fa-print"></i>
                        </a>
                        <a data-id="' . $data->id . '"
                            data-title="' . $data->kode . '"
                            data-url="/api/v1/item/' . $data->id . '"
                            class="btn btn-outline-warning text-warning editData"><i class="fa fa-edit"></i>
                        </a>
                        <a data-id="' . $data->id . '"
                            data-title="' . $data->kode . '"
                            data-url="/aktivitas/list/'.$data->id.'"
                            class="btn btn-outline-danger text-danger deleteData"><i class="fa fa-ban"></i>
                        </a>'
                        ;
            })
            ->addColumn('barcode', function ($data) {
                return "<img src='$data->barcode' alt='barcode' width='80px'>";
            })
            ->addColumn('status_label', function ($data) {
                return $data->status_label;
            })
            ->rawColumns(['action', 'barcode', 'status_label'])
            ->make(true);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

}
