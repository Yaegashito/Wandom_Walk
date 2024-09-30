<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Calendar extends Model
{
    protected $table = 'calendar';
    protected $fillable = ['done', 'date'];
    public $timestamps = false;

    use HasFactory;

    public static function storeCalendar($today)
    {
        $calendar = self::firstOrNew(['date' => $today]);
        $calendar->user_id = Auth::id();
        $calendar->save();
    }
}
