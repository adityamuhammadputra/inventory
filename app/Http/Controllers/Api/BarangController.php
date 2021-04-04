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
        try {
            $barang = $request->all();
            $barang['id'] = uuid();
            $barang['harga'] = inputRupiah($request->harga);
            $barang['kategori'] = substr($request->kode, 0, 2);
            $barang['kategori_no'] = substr($request->kode, 2);
            $barang['barcode'] = generateBarcode($request->kode);
            $barang['user_id'] = 1;
            $barang['status'] = 1;
            $barang = Barang::create($barang);
            $data = [
                'barang' => $barang,
                'maxKode' => Barang::maxKode($barang->kategori),
            ];
        } catch (Exception $th) {
            $data = $th;
        }

        return response()->json($data);
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
