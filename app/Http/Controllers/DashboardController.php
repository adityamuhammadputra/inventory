<?php

namespace App\Http\Controllers;

use App\Event;
use App\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


        $event = DB::select("SELECT
                    SUM(CASE MONTH(date_start) WHEN 1 THEN 1 ELSE 0 END) AS 'January',
                    SUM(CASE MONTH(date_start) WHEN 2 THEN 1 ELSE 0 END) AS 'February',
                    SUM(CASE MONTH(date_start) WHEN 3 THEN 1 ELSE 0 END) AS 'March',
                    SUM(CASE MONTH(date_start) WHEN 4 THEN 1 ELSE 0 END) AS 'April',
                    SUM(CASE MONTH(date_start) WHEN 5 THEN 1 ELSE 0 END) AS 'May',
                    SUM(CASE MONTH(date_start)WHEN 6 THEN 1 ELSE 0 END) AS 'June',
                    SUM(CASE MONTH(date_start) WHEN 7 THEN 1 ELSE 0 END) AS 'July',
                    SUM(CASE MONTH(date_start) WHEN 8 THEN 1 ELSE 0 END) AS 'August',
                    SUM(CASE MONTH(date_start) WHEN 9 THEN 1 ELSE 0 END) AS 'September',
                    SUM(CASE MONTH(date_start) WHEN 10 THEN 1 ELSE 0 END) AS 'October',
                    SUM(CASE MONTH(date_start) WHEN 11 THEN 1 ELSE 0 END) AS 'November',
                    SUM(CASE MONTH(date_start) WHEN 12 THEN 1 ELSE 0 END) AS 'December',
                    SUM(CASE YEAR(date_start) WHEN 2021 THEN 1 ELSE 0 END) AS 'TOTAL'
                FROM
                    events");

        $rental = DB::select("SELECT
                        SUM(CASE MONTH(start) WHEN 1 THEN 1 ELSE 0 END) AS 'January',
                        SUM(CASE MONTH(start) WHEN 2 THEN 1 ELSE 0 END) AS 'February',
                        SUM(CASE MONTH(start) WHEN 3 THEN 1 ELSE 0 END) AS 'March',
                        SUM(CASE MONTH(start) WHEN 4 THEN 1 ELSE 0 END) AS 'April',
                        SUM(CASE MONTH(start) WHEN 5 THEN 1 ELSE 0 END) AS 'May',
                        SUM(CASE MONTH(start)WHEN 6 THEN 1 ELSE 0 END) AS 'June',
                        SUM(CASE MONTH(start) WHEN 7 THEN 1 ELSE 0 END) AS 'July',
                        SUM(CASE MONTH(start) WHEN 8 THEN 1 ELSE 0 END) AS 'August',
                        SUM(CASE MONTH(start) WHEN 9 THEN 1 ELSE 0 END) AS 'September',
                        SUM(CASE MONTH(start) WHEN 10 THEN 1 ELSE 0 END) AS 'October',
                        SUM(CASE MONTH(start) WHEN 11 THEN 1 ELSE 0 END) AS 'November',
                        SUM(CASE MONTH(start) WHEN 12 THEN 1 ELSE 0 END) AS 'December',
                        SUM(CASE YEAR(start) WHEN 2021 THEN 1 ELSE 0 END) AS 'TOTAL'
                    FROM
                        rentals");



        $graph = json_decode(json_encode($event[0]), true);
        $graph = implode(",",$graph);
        $graphEvent = '['. $graph . ']';

        $graph = json_decode(json_encode($rental[0]), true);
        $graph = implode(",",$graph);
        $graphRental= '['. $graph . ']';

        $data = (object) [
            'totalEvent' => Event::count(),
            'totalRental' => Rental::count(),
            'EarningEvent' => outputRupiah(Event::sum('total')),
            'EarningRental' => outputRupiah(Rental::sum('total')),
            'timeline' => json_decode(json_encode($results), FALSE),
            'graphRental' => $graphRental,
            'graphEvent' => $graphEvent,
        ];

        logActivities("View Dashboard page");
        return view('dashboard.index', compact('data'));
    }

}
