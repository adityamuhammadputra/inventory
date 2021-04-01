<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
}
