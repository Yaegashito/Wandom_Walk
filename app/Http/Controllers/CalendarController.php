<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function recordCalendar()
    {
        $today = Carbon::today()->toDateString();

        $calendar = Calendar::firstOrNew(['date' => $today]);
        $calendar->done = true;
        $calendar->save();

        return response()->json(['success' => true, 'date' => $today]);
    }

    public function storeCalendar(Request $request)
    {
        $today = Carbon::create($request->year, $request->month, $request->date);
        $lastMonthMiddleDay = $today->clone()->subMonth()->day(15);
        $records = Calendar::where('date', '>', $lastMonthMiddleDay)->select('date')->get();;
        return response()->json(['records' => $records]);
    }
}
