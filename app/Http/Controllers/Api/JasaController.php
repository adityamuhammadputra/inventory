<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Operator;
use App\Vendor;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JasaController extends Controller
{
    public function dataTable(Request $request)
    {
        if($request->model == 'OP') :
            $data = Operator::query();
        elseif($request->model == 'VE') :
            $data = Vendor::query();
        else :
            $data = Client::query();
        endif;

        return DataTables::of($data)
            ->addColumn('action', function ($data) use($request){
                return '<a data-id="' . $data->id . '"
                            data-title="' . $data->nama . '"
                            data-url="/api/v1/jasa/' . $data->id . '/edit?model=' . $request->model . '"
                            class="btn btn-outline-warning text-warning editData"><i class="fa fa-edit"></i>
                        </a>
                        <a data-id="' . $data->id . '"
                            data-title="' . $data->nama . '"
                            data-url="/api/v1/jasa/' . $data->id . '?model=' . $request->model . '"
                            class="btn btn-outline-danger text-danger deleteData"><i class="fa fa-ban"></i>
                        </a>'
                        ;
            })
            ->addColumn('status_label', function ($data) {
                return $data->status_label;
            })
            ->rawColumns(['action', 'barcode', 'status_label'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        $input['id'] = uuid();
        try {
            if($request->model == 'OP') :
                $table = 'tableOperator';
                $input['vendor_nama'] = Vendor::find($request->vendor_id)->nama;
                $data = Operator::create($input);
            elseif($request->model == 'VE') :
                $table = 'tableVendor';
                $data = Vendor::create($input);
            else :
                $table = 'tableClient';
                $data = Client::create($input);
            endif;

            $result = (object) [
                'table' => $table,
                'data' => $data,
                'status' => 200,
            ];

        } catch (Exception $th) {
            $result = (object) [
                'data' => $th,
                'status' => 401,
            ];
            $data = $th;
        }
        return response()->json($result, $result->status);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request, $id)
    {
        if($request->model == 'OP')
            $data = Operator::findOrFail($id);
        else if($request->model == 'VE')
            $data = Vendor::findOrFail($id);
        else
            $data = Client::findOrFail($id);

        $result = $data;
        $data->delete();

        return response()->json($result, 200);
    }

}
