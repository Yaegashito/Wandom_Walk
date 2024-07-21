<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Belonging;

class BelongingController extends Controller
{
    public function store(Request $request)
    {
        $belonging = new Belonging();
        $belonging->belonging = $request->belonging;
        $belonging->save();

        return redirect()->route('top');
    }

    public function destroy(Belonging $belonging)
    {
        $belonging->delete();
        // return redirect()->route('top');
    }
}
