<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Belonging extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'belonging',
    ];

    public static function storeBelonging($belongingInput)
    {
        return self::create([
            'user_id' => Auth::id(),
            'belonging' => $belongingInput,
        ]);
    }
}
