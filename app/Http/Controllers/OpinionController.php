<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opinion;

class OpinionController extends Controller
{
    public function submitOpinion(Request $request): void
    {
        Opinion::submitOpinion($request->opinion);
    }
}
