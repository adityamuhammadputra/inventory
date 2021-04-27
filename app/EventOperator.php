<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventOperator extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = ['ids', 'op_name'];
    protected $with = ['operator'];

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function getIdsAttribute()
    {
        if($this->attributes['operator_tugas'] == 'Fotografer')
            return 1;
        else if($this->attributes['operator_tugas'] == 'Videografer')
            return 2;
        else if($this->attributes['operator_tugas'] == 'SDE')
            return 3;
        else if($this->attributes['operator_tugas'] == 'Crew')
            return 4;
        else
            return 5;
    }

    public function getOpNameAttribute()
    {
        return $this->operator->tugas . ' - ' . $this->operator->kode . ' - ' . $this->operator->nama . ' - ' .$this->operator->harga;
    }

    public function getOperatorTotalAttribute($val)
    {
        return outputRupiah($val);
    }
}
