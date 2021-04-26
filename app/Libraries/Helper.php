<?php

use App\Barang;
use App\Event;
use App\Log;
use App\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use DNS1D;

function uuid()
{
    return Uuid::uuid1();
}

function userId()
{
    return Auth::user()->id;
}

function dateInput($date)
{
    //ex: 03 October 2020
    $d =  Carbon::createFromFormat('d F Y', $date);
    return Carbon::parse($d)->format('Y-m-d');
}

function dateOutput($date)
{
    return Carbon::parse($date)->format('d F Y');
}

function timeOutput($date)
{
    return Carbon::parse($date)->format('H:i');
}

function dateTimeOutput($date)
{
    return Carbon::parse($date)->format('d F Y H:i');
}

function inputRupiah($input)
{
    // Rp.123.123.123,00
    // return str_replace(['Rp.', 'Rp.', '.'] , '', explode(",", $input)[0]);
    return str_replace(['Rp. ', 'Rp.', '.'] , '', $input);
}

function outputRupiah($input)
{
    return "Rp." . number_format($input,0,'','.');
}

function dateTimeOutputId($dateTime, $printDay = false, $printTime = true) //Carbon::setLocale('id') doesnt work
{
	$day = [1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			];

	$month = [1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
            ];

    $splitDateTime = explode(' ', $dateTime);
    $splitDate	   = explode('-', $splitDateTime[0]);
    $splitTime     = substr($splitDateTime[1], 0 , -3);

    $dateId = $splitDate[2] . ' ' . $month[ (int)$splitDate[1] ] . ' ' . $splitDate[0];

	if ($printDay) {
        $num = date('N', strtotime($splitDateTime[0]));
        if($printTime)
            return $day[$num] . ', ' . $dateId . ' ' .$splitTime;
        else
            return $day[$num] . ', ' . $dateId;
    }
    if($printDay == false && $printTime)
        return $dateId . ' ' .$splitTime;
    else
        return $dateId;
}


function getAllJenis()
{
    return Barang::orderBy('jenis')->pluck('id', 'jenis');
}

function generateBarcode($name)
{
    // generateBarcode('test123');
    Storage::disk('public_barcode')->put($name.'.svg', DNS1D::getBarcodeSVG("$name", "C128", 2, 100));
    return '/img/barcode/'.$name . '.svg';
}


function getMaxRental()
{
    $noReg = 'RE00001';
    if(Rental::count() > 0) :
        $max = Rental::max('noreg');
        $maxDigit = substr($max, 2) + 1;
        $maxKode = substr($max, 0, 2);
        if($maxDigit < 9)
            $nol = "0000";
        else if ($maxDigit < 99)
            $nol = "000";
        else if ($maxDigit < 999)
            $nol = "00";
        else
            $nol = "0";

        $noReg = $maxKode . $nol . $maxDigit;
    endif;

    return $noReg;
}


function getMaxEvent()
{
    $noReg = 'EV00001';
    if(Event::count() > 0) :
        $max = Event::max('noreg');
        $maxDigit = substr($max, 2) + 1;
        if($maxDigit < 9)
            $nol = "0000";
        else if ($maxDigit < 99)
            $nol = "000";
        else if ($maxDigit < 999)
            $nol = "00";
        else
            $nol = "0";


        $maxKode = substr($max, 0, 2);
        $noReg = $maxKode . $nol . $maxDigit;
    endif;

    return $noReg;
}


function logActivities($content)
{
    $data = [
        'id' => uuid(),
        'user_id' => userId(),
        'url' => request()->fullUrl(),
        'method' => request()->method(),
        'content' => $content,
    ];
    Log::create($data);
}

function logsLastest()
{
    return Log::orderBy('created_at', 'desc')->paginate(5);
}
