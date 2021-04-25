<?php

namespace App\Http\Controllers;

use App\Event;
use App\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $rental = Rental::select('id', 'noreg', 'nama as name', 'start', 'end', 'alamat as location', 'total as sub_total', 'total as sub_total_op', 'total', 'status')
                        ->whereMonth('start', Carbon::now()->format('m'))
                        ->get();

        $event = Event::select('id', 'noreg', 'name', 'date_start as start', 'date_end as end', 'location', 'sub_total', 'sub_total_op', 'total', 'status')
                        ->whereMonth('date_start', Carbon::now()->format('m'))
                        ->get();

        $merged = $rental->merge($event);

        $result = $merged->all();

        $results = [];
        foreach($result as $result) :
            $results [] = [
                'id' => $result->id,
                'noreg' => $result->noreg,
                'name' => $result->name,
                'start' => ($result->jenis == 'Event') ? dateOutput($result->start) : $result->start,
                'end' => ($result->jenis == 'Event') ? dateOutput($result->end) : $result->end,
                'location' => $result->location,
                'total' => $result->total,
                'status' => $result->status,
                'jenis' => $result->jenis,
                'items' => $result->items,
                'url' => ($result->jenis == 'Event') ? "/event/{$result->id}/edit" : "/rental/{$result->id}/edit"
            ];
        endforeach;

        $data = (object) [
            'totalEvent' => Event::count(),
            'totalRental' => Rental::count(),
            'EarningEvent' => outputRupiah(Event::sum('total')),
            'EarningRental' => outputRupiah(Rental::sum('total')),
            'timeline' => json_decode(json_encode($results), FALSE),
        ];

        return view('dashboard.index', compact('data'));
    }

}
