<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentalBarang extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['count_item', 'equpment'];
    protected $with = ['barang'];

    public function rentalBarangItems()
    {
        return $this->hasMany(RentalBarangItem::class);
    }

    public function getCountItemAttribute()
    {
        return $this->rentalBarangItems->count();
    }

    public function getEqupmentAttribute()
    {
        return $this->barang->kode . ' - ' . $this->barang->jenis . ' - ' .$this->barang->harga;
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

}
