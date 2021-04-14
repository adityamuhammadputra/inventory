<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventBarang extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['count_item'];

    public function eventBarangItems()
    {
        return $this->hasMany(EventBarangItem::class);
    }

    public function getCountItemAttribute()
    {
        return $this->eventBarangItems->count();
    }

}
