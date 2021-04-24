<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangLog extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['date'];

    public function getDateAttribute()
    {
        return $this->start . ' s/d ' . $this->end;
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
