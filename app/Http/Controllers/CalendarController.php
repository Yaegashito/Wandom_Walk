<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function changeCalendar(Request $request): JsonResponse
    {
        $today = Carbon::create($request->year, $request->month, $request->date);
        $lastMonthMiddleDay = $today->clone()->subMonth()->day(15);
        $records = Auth::user()->calendars()->where('date', '>', $lastMonthMiddleDay)->select('date')->get();;
        return response()->json(['records' => $records]);
    }

    public function storeCalendar(): JsonResponse
    {
        $today = Carbon::today()->toDateString();

        Calendar::storeCalendar($today);

        return response()->json(['success' => true, 'date' => $today]);
    }
}
