<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;


    public function scopeNoreg($query, $kategori)
    {
        $max = $query->max('Noreg');
        $maxPlus = str_pad($max + 1, 3, '00', STR_PAD_LEFT);
        return $kategori . $maxPlus;
    }
}
