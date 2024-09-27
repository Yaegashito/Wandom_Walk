<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opinion;
use Illuminate\Support\Facades\Auth;

class OpinionController extends Controller
{
    public function submitOpinion(Request $request)
    {
        $opinion = new Opinion();
        $opinion->user_id = Auth::user()->id;
        $opinion->opinion = $request->opinion;
        $opinion->save();
    }
}
