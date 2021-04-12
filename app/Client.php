<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;


    public function getCreatedAtAttribute($val)
    {
        if($val)
            return dateTimeOutput($val);
        return '-';
    }


    public function scopeFiltered($query)
    {
        $query->when(request('q'), function ($query) {
            $param = '%' . request('q') . '%';
            $query->where('nama', 'like', $param)
                ->orWhere('keterangan', 'like', $param);
        });
    }
}
