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

        $position = '<a href="/event" class="text-default">E</a>';
        if($this->rental_id)
            $position = '<a href="/rental" class="text-default">R</a>';
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
