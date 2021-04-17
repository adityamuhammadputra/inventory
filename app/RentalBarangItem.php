<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class RentalBarangItem extends Model
{
    protected $appends = ['equpment'];


    public function barang(): belongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    public function getEqupmentAttribute()
    {
        return $this->barang->kode . ' - ' . $this->barang->jenis . ' - ' .$this->barang->harga;
    }
}
