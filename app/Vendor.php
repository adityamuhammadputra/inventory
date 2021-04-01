<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
}
