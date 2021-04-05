<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['status_label'];


    public function getCreatedAtAttribute($val)
    {
        if($val)
            return dateTimeOutput($val);
        return '-';
    }

    public function getStatusLabelAttribute()
    {
        if($this->status == 1)
            return '<span class="badge badge-primary">available</span>';

        return '<span class="badge badge-secondary">not available</span>';
    }

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
            // ->orWhereHas('x', function($q) use($param) {
            //     $q->whereHas('t', function($q) use ($param){
            //         $q->where('x', 'like', $param);
            //         $q->orWhere('x', 'like', $param);
            //     });
            // })
        });


        $query->when(request('jenis'), function ($query) {
            $query->where('jenis', request('jenis'));
        });

        $query->when(request('status'), function ($query) {
            $query->where('status', request('status'));
        });

        $query->when(request('harga'), function ($query) {
            if(inputRupiah(request('harga')))
                $query->where('harga','>=', inputRupiah(request('harga')));
        });
    }


    public function scopeCheckBarang($query)
    {
        $query->when(request('column'), function ($query) {
            $column = request('column');
            $value = request('value');

            $query->where($column, $value);
        });
    }

    public function scopeItem($query)
    {
        $query->where('kategori', 'IP');
    }

    public function scopeEquipment($query)
    {
        $query->where('kategori', 'EP');
    }

    public function scopeMaxKode($query, $kategori)
    {
        $max = $query->max('kategori_no');
        $maxPlus = str_pad($max + 1, 3, '00', STR_PAD_LEFT);
        return $kategori . $maxPlus;
    }
}
