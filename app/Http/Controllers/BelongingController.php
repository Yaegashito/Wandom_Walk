<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Belonging;
use Illuminate\Http\JsonResponse;

class BelongingController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $belonging = Belonging::storeBelonging($request->belonging);

        return response()->json(['id' => $belonging->id]);
    }

    public function destroy(Belonging $belonging): void
    {
        $belonging->delete();
    }
}
