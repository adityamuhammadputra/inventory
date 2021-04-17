<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
class EventBarangItem extends Model
{
    protected $appends = ['equpment'];
    /**
     * Get the user associated with the EventBarangItem
     *
     * @return
     */
    public function barang(): belongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    public function getEqupmentAttribute()
    {
        return $this->barang->kode . ' - ' . $this->barang->jenis . ' - ' .$this->barang->harga;
    }
}
