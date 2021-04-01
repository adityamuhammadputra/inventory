<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function dataTable()
    {
        $data = Barang::filtered();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {

                $delete = '<a data-id="' . $data->id . '"
                                data-title="' . $data->kode . '"
                                data-url="/aktivitas/list/'.$data->id.'"
                                class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only text-danger deleteData"><i class="fa fa-ban"></i>
                            </a>';
                return '<a href="/aktivitas/list/' . $data->id . '/edit"
                            class="btn btn-outline-warning m-btn m-btn--icon m-btn--icon-only text-warning"><i class="fa fa-edit"></i>
                        </a>'
                        .$delete;
            })
            ->rawColumns(['action'])
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
