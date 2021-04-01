<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
}
