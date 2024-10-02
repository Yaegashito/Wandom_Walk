<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Belonging;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TopController extends Controller
{
    public function top(): View
    {
        $belongings = Auth::user()->belongings()->oldest()->get();

        $GOOGLE_MAPS_API_KEY = config('services.googlemaps.api_key');

        return view('top')
            ->with([
                'key' => $GOOGLE_MAPS_API_KEY,
                'belongings' => $belongings,
                'userName' => Auth::user()->name,
            ]);
    }
}
