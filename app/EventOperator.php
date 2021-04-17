<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventOperator extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['ids'];

    public function getIdsAttribute()
    {
        if($this->attributes['operator_tugas'] == 'Camerament')
            return 1;
        else if($this->attributes['operator_tugas'] == 'Crew')
            return 2;
        else if($this->attributes['operator_tugas'] == 'SDE')
            return 3;
        else
            return 4;
    }
}
