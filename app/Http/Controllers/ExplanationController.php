<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExplanationController extends Controller
{
    public function showExplanation()
    {
        return view('explanation');
    }
}
