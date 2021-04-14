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
            $query->where('noreg', 'like', $param)
                ->orWhere('nama', 'like', $param)
                ->orWhere('kontak', 'like', $param)
                ->orWhere('alamat', 'like', $param);
        });

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
