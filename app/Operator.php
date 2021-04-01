<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
}
