<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;


    public function rentalBarangs()
    {
        return $this->hasMany(RentalBarang::class)->with('rentalBarangItems');
    }

    public function scopeCheckNoreg($query)
    {
        $query->when(request('column'), function ($query) {
            $column = request('column');
            $value = request('value');

            $query->where($column, $value);
        });
    }

    public function scopeFiltered($query)
    {

        //for custom datatable
        $query->when(request('search'), function ($query) {
            $param = '%' . request('search')['value'] . '%';

            $query->where(function ($query) use ($param){
                $query->where('noreg', 'like', $param)
                ->orWhere('nama', 'like', $param)
                ->orWhere('kontak', 'like', $param)
                ->orWhere('alamat', 'like', $param);
            });
        });

        $query->when(!request('aproved'), function ($query) {
            $query->where('status', 1);
        });

        $query->when(request('aproved'), function ($query) {
            $query->where('status', 2);
        });

        $query->when(request('total'), function ($query) {
            if(inputRupiah(request('total')))
                $query->where('total','>=', inputRupiah(request('total')));
        });
    }

    public function getTotalAttribute($val)
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

    public function getStartAttribute($val)
    {
        if($val)
            return dateOutput($val);
        return '-';
    }

    public function getEndAttribute($val)
    {
        if($val)
            return dateOutput($val);
        return '-';
    }
}
