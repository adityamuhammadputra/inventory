<?php

namespace App\Http\Controllers\Api;

use App\Barang;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function dataTable(Request $request)
    {
        if($request->kategori == 'IP')
            $data = Barang::item();
        else{
            $data = Barang::equipment();
        }
        $data = $data->filtered();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<a href="'.$data->barcode.'" target="_blank"
                            class="text-info"><i class="fa fa-print"></i>
                        </a>
                        <a data-id="' . $data->id . '"
                            data-title="' . $data->kode . '"
                            data-url="/api/v1/barang/' . $data->id . '"
                            class="text-warning editData"><i class="fa fa-edit"></i>
                        </a>
                        <a data-id="' . $data->id . '"
                            data-title="' . $data->kode . '"
                            data-url="/api/v1/barang/'.$data->id.'"
                            class="text-danger deleteData"><i class="fa fa-trash"></i>
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
       $input = $this->inputData($request);
       $input['id'] = uuid();

        try {
            $barang = Barang::create($input);
            $result = [
                'barang' => $barang,
                'maxKode' => Barang::maxKode($barang->kategori),
            ];
        } catch (Exception $th) {
            $result = $th;
        }

        return response()->json($result);
    }

    public function show(Barang $barang)
    {
        $result = [
            'data' => $barang,
            'action' => "/api/v1/barang/{$barang->id}"
        ];
        return response()->json($result);
    }

    public function update(Request $request, Barang $barang)
    {

       $input = $this->inputData($request);
        try {
            $barang->update($input);
            $result = [
                'barang' => $barang,
                'maxKode' => Barang::maxKode($barang->kategori),
            ];
        } catch (Exception $th) {
            $result = $th;
        }

        return response()->json($result);
    }


    public function destroy(Barang $barang)
    {
        return $barang->delete();
    }

    public function maxKode($kategori)
    {
        $kategori = substr($kategori,0,2);
        return Barang::maxKode($kategori);
    }

    function inputData($request)
    {
        $barang = $request->except('_token', '_method');
        $barang['harga'] = inputRupiah($request->harga);
        $barang['kategori'] = substr($request->kode, 0, 2);
        $barang['kategori_no'] = substr($request->kode, 2);
        $barang['barcode'] = generateBarcode($request->kode);
        $barang['user_id'] = 1;
        $barang['status'] = 1;

        return $barang;
    }

}
