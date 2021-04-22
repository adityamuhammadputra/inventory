<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventBarang extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['count_item', 'equpment', 'items'];

    public function eventBarangItems()
    {
        return $this->hasMany(EventBarangItem::class)->with('barang');
    }

    public function getCountItemAttribute()
    {
        return $this->eventBarangItems->count();
    }
    public function getItemsAttribute()
    {
        return $this->eventBarangItems->pluck('barang_name')->implode('                                         ');
    }

    public function getEqupmentAttribute()
    {
        return $this->barang->kode . ' - ' . $this->barang->jenis . ' ' . $this->barang->merk . ' - ' .$this->barang->harga;
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

}
