<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function showCalendar(Request $request)
    {
        $today = Carbon::create($request->year, $request->month, $request->date);
        $lastMonthMiddleDay = $today->clone()->subMonth()->day(15);
        $records = Auth::user()->calendars()->where('date', '>', $lastMonthMiddleDay)->select('date')->get();;
        return response()->json(['records' => $records]);
    }

    public function storeCalendar()
    {
        $today = Carbon::today()->toDateString();

        $calendar = Calendar::firstOrNew(['date' => $today]);
        $calendar->user_id = Auth::user()->id;
        $calendar->save();

        return response()->json(['success' => true, 'date' => $today]);
    }

}
