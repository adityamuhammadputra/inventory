<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $guarded = [''];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['status_label', 'logs'];

    public function barangLogs()
    {
        return $this->hasMany(BarangLog::class, 'barang_kode', 'kode')->orderBy('start', 'desc')->take(5);
    }

    public function getLogsAttribute($val)
    {
        return $this->barangLogs->pluck('date');
    }

    public function getCreatedAtAttribute($val)
    {
        if($val)
            return dateTimeOutput($val);
        return '-';
    }

    public function getStatusLabelAttribute()
    {
        if($this->status == 1)
            return '<span class="badge badge-primary">available</span>';

        return '<span class="badge badge-secondary" style="text-decoration: line-through;">available</span>';
    }


    public function getHargaAttribute()
    {
        return outputRupiah($this->attributes['harga']);
    }

    public function scopeFiltered($query)
    {
        //for custom datatable
        $query->when(request('search'), function ($query) {
            $param = '%' . request('search')['value'] . '%';
            $query->where('kode', 'like', $param)
                ->orWhere('jenis', 'like', $param)
                ->orWhere('merk', 'like', $param)
                ->orWhere('type', 'like', $param)
                ->orWhere('serial_number', 'like', $param);
            // ->orWhereHas('x', function($q) use($param) {
            //     $q->whereHas('t', function($q) use ($param){
            //         $q->where('x', 'like', $param);
            //         $q->orWhere('x', 'like', $param);
            //     });
            // })
        });


        $query->when(request('jenis'), function ($query) {
            $query->where('jenis', request('jenis'));
        });

        $query->when(request('status'), function ($query) {
            $query->where('status', request('status'));
        });

        $query->when(request('harga'), function ($query) {
            if(inputRupiah(request('harga')))
                $query->where('harga','>=', inputRupiah(request('harga')));
        });

        $query->when(request('q'), function ($query) {
            $param = '%' . request('q') . '%';
            $query->where('kategori_no', 'like', $param)
                ->orWhere('kode', 'like', $param)
                ->orWhere('merk', 'like', $param)
                ->orWhere('jenis', 'like', $param)
                ->orWhere('type', 'like', $param)
                ->orWhere('serial_number', 'like', $param);
        });
    }


    public function scopeCheckBarang($query)
    {
        $query->when(request('column'), function ($query) {
            $column = request('column');
            $value = request('value');

            $query->where($column, $value);
        });
    }

    public function scopeItem($query)
    {
        $query->where('kategori', 'IP');
    }

    public function scopeEquipment($query)
    {
        $query->where('kategori', 'EP');
    }

    public function scopeAvailable($query)
    {
        $query->when(request('start'), function ($query) {
            $query->whereDoesntHave('barangLogs', function($q){
                $q->where('start', '>=', dateInput(request('start')))
                    ->where('end', '<=', dateInput(request('end')))
                    ->whereNull('deleted_at');
            });
        });
    }

    public function scopeMaxKode($query, $kategori)
    {

        if($kategori == 'IP')
            $query->where('kategori', 'IP');
        else
            $query->where('kategori', 'EP');

        $max = $query->max('kode');
        if(!isset($max))
            return $kategori . '000' . '1';

        $maxDigit = substr($max, 2) + 1;
        if($maxDigit < 9)
            $nol = "000";
        else if ($maxDigit < 99)
            $nol = "00";
        else
            $nol = "0";

        $maxKode = substr($max, 0, 2);
        $noReg = $maxKode . $nol . $maxDigit;

        return $noReg;
    }
}
