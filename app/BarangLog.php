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
        $check = '';
        if($this->deleted_at)
            $check = ' <span class="mdi mdi-check text-primary"></span>';

        $position = 'E';
        if($this->rental_id)
            $position = 'R';
        return "{$this->start} s/d {$this->end} $position {$check}";
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
