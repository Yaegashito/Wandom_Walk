<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\BelongingController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\ExplanationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('top'); // ログイン済みなら 'home' にリダイレクト
    }
    return view('start');
})->name('start');

Route::get('/explanation', [ExplanationController::class, 'showExplanation'])->name('explanation');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('changeCalendar', [CalendarController::class, 'changeCalendar'])->name('changeCalendar');
Route::post('storeCalendar', [CalendarController::class, 'storeCalendar'])->name('storeCalendar');

Route::post('submitOpinion', [OpinionController::class, 'submitOpinion'])->name('submitOpinion');

Route::get('/top', [TopController::class, 'top'])->middleware(['auth'])->name('top');
Route::resource('belonging', BelongingController::class)->except(['index', 'create', 'show', 'edit', 'update']);
