<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Belonging;
use Illuminate\Support\Facades\Auth;

class BelongingController extends Controller
{
    public function store(Request $request)
    {
        $belonging = new Belonging();
        $belonging->user_id = Auth::user()->id;
        $belonging->belonging = $request->belonging;
        $belonging->save();

        return response()->json(['id' => $belonging->id]);
    }

    public function destroy(Belonging $belonging)
    {
        $belonging->delete();
    }
}
