<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Get the user that owns the Operator
     *
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function getCreatedAtAttribute($val)
    {
        if($val)
            return dateTimeOutput($val);
        return '-';
    }
}
