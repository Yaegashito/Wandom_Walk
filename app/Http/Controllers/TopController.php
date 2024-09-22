<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Belonging;

class TopController extends Controller
{
    public function top()
    {
        $belongings = Belonging::oldest()->get();

        $GOOGLE_MAPS_API_KEY = config('services.googlemaps.api_key');

        return view('top')
            ->with(['key' => $GOOGLE_MAPS_API_KEY, 'belongings' => $belongings]);
    }
}
