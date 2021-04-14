<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;


    public function eventOperator()
    {
        return $this->hasMany(EventOperator::class);
    }

    public function eventBarangs()
    {
        return $this->hasMany(EventBarang::class)->with('eventBarangItems');
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
            $query->where('vendor_nama', 'like', $param)
                ->orWhere('client_nama', 'like', $param)
                ->orWhere('location', 'like', $param);
        });

    }
}
