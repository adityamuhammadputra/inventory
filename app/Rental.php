<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;


    public function scopeCheckNoreg($query)
    {
        $query->when(request('column'), function ($query) {
            $column = request('column');
            $value = request('value');

            $query->where($column, $value);
        });
    }
}
