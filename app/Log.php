<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['icon'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getIconAttribute()
    {
        if($this->method == 'GET')
            return (object)['data' => 'activity', 'color' => 'info'];
        else if($this->method == 'POST')
            return (object)['data' => 'plus', 'color' => 'success'];
        else if($this->method == 'PATCH')
            return (object)['data' => 'edit', 'color' => 'warning'];
        else if($this->method == 'DELETE')
            return (object)['data' => 'trash', 'color' => 'danger'];
        else
            return (object)['data' => 'alert-circle', 'color' => 'danger'];
    }
}
