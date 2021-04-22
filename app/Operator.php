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
     * Camerament Crew SDE Editor
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

    public function scopeFiltered($query)
    {
        $query->when(request('q'), function ($query) {
            $param = '%' . request('q') . '%';
            $query->where('nama', 'like', $param)
                ->orWhere('tugas', 'like', $param)
                ->orWhere('vendor_nama', 'like', $param);
        });
    }

    public function getHargaAttribute()
    {
        return outputRupiah($this->attributes['harga']);
    }
}
