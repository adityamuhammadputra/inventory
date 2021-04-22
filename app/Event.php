<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['sub_total_all'];


    public function eventOperator()
    {
        return $this->hasMany(EventOperator::class)->orderBy('operator_tugas');
    }

    public function eventBarangs()
    {
        return $this->hasMany(EventBarang::class)->with('barang', 'eventBarangItems');
    }

    public function scopeNoreg($query, $kategori)
    {
        $max = $query->max('Noreg');
        $maxPlus = str_pad($max + 1, 3, '00', STR_PAD_LEFT);
        return $kategori . $maxPlus;
    }

    public function scopeFiltered($query)
    {
        //for custom datatable
        $query->when(request('search'), function ($query) {
            $param = '%' . request('search')['value'] . '%';
            $query->where('vendor_name', 'like', $param)
                ->orWhere('client_name', 'like', $param)
                ->orWhere('location', 'like', $param);
        });

    }

    public function getSubTotalAllAttribute()
    {
        $subTotal = $this->attributes['sub_total'] + $this->attributes['sub_total_op'];
        return outputRupiah($subTotal);
    }

    public function getTotalAttribute($val)
    {
        return outputRupiah($val);
    }

    public function getSubTotalOpAttribute($val)
    {
        return outputRupiah($val);
    }

    public function getSubTotalAttribute($val)
    {
        return outputRupiah($val);
    }

    public function getCreatedAtAttribute($val)
    {
        if($val)
            return dateTimeOutput($val);
        return '-';
    }

    public function getDateStartAttribute($val)
    {
        if($val)
            return dateOutput($val);
        return '-';
    }

    public function getDateEndAttribute($val)
    {
        if($val)
            return dateOutput($val);
        return '-';
    }
}
