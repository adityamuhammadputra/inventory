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
            $data = Operator::with('vendor');
        elseif($request->model == 'VE') :
            $data = Vendor::query();
        else :
            $data = Client::query();
        endif;

        return DataTables::of($data)
            ->addColumn('action', function ($data) use($request){
                return '<a data-id="' . $data->id . '"
                            data-title="' . $data->nama . '"
                            data-url="/api/v1/jasa/' . $data->id . '?model=' . $request->model . '"
                            class="text-warning editData"><i class="fa fa-edit mr-1"></i>
                        </a>
                        <a data-id="' . $data->id . '"
                            data-title="' . $data->nama . '"
                            data-url="/api/v1/jasa/' . $data->id . '?model=' . $request->model . '"
                            class="text-danger deleteData">
                            <i class="fa fa-trash"></i>
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
        $input = $request->except('_token', '_method');
        $input['id'] = uuid();

        if($request->harga)
            $input['harga'] = inputRupiah($request->harga);

        try {
            if($request->model == 'OP') :
                $table = 'tableOperator';
                $vendor = Vendor::find($request->vendor_id);
                $input['vendor_nama'] = $vendor->nama ?? '';
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

        } catch (Exception $e) {
            $result = (object) [
                'data' => $e,
                'status' => 401,
            ];
        }
        return response()->json($result, $result->status);
    }

    public function show(Request $request, $id)
    {
        try {
            if($request->model == 'OP') :
                $data = Operator::findOrFail($id);
            elseif($request->model == 'VE') :
                $data = Vendor::findOrFail($id);
            else :
                $data = Client::findOrFail($id);
            endif;
            $result = (object) [
                'status' => 200,
                'data' => $data,
                'action' => "/api/v1/jasa/{$data->id}?model={$request->model}"
            ];

        } catch (Exception $e) {
            $result = (object) [
                'data' => $e,
                'status' => 401,
            ];
        }

        return response()->json($result, $result->status);
    }

    public function update(Request $request, $id)
    {
        $input = $request->except('_token', '_method');
        if($request->harga)
            $input['harga'] = inputRupiah($request->harga);

        if($request->model == 'OP')
            $data = Operator::findOrFail($id);
        else if($request->model == 'VE')
            $data = Vendor::findOrFail($id);
        else
            $data = Client::findOrFail($id);

        try {
            $data->update($input);
            $result = (object) [
                'status' => 200,
                'data' => $data,
                'action' => "/api/v1/jasa/{$data->id}"
            ];
        } catch (Exception $e) {
            $result = (object) [
                'data' => $e,
                'status' => 401,
            ];
        }

        return response()->json($result, $result->status);
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
