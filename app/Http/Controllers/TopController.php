<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopController extends Controller
{
    public function top()
    {
        $GOOGLE_MAPS_API_KEY = config('services.googlemaps.api_key');
        $belongings = ['リード', '水', '袋'];
        return view('test')
            ->with(['key' => $GOOGLE_MAPS_API_KEY, 'belongings' => $belongings]);
    }
}
