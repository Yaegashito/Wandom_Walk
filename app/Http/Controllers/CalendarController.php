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
}
