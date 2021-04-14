<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentalBarang extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['count_item'];

    public function rentalBarangItems()
    {
        return $this->hasMany(RentalBarangItem::class);
    }

    public function getCountItemAttribute()
    {
        return $this->rentalBarangItems->count();
    }

}
