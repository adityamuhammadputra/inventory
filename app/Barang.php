<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;



    public function scopeFiltered($query)
    {
        //for custom datatable
        $query->when(request('search')['value'], function ($query) {
            $param = '%' . request('search')['value'] . '%';
            $query->where('kode', 'like', $param)
                ->orWhere('jenis', 'like', $param)
                ->orWhere('merk', 'like', $param)
                ->orWhere('type', 'like', $param)
                ->orWhere('serial_number', 'like', $param);

            // ->orWhereHas('mapUnitOrg', function($q) use($param) {
            //     $q->whereHas('pegawai', function($q) use ($param){
            //         $q->where('nm_peg', 'like', $param);
            //         $q->orWhere('Nip', 'like', $param);
            //     });
            // })
        });
    }

}
