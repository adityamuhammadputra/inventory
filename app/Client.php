<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
}
