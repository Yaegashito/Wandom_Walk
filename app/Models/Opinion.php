<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Opinion extends Model
{
    protected $fillable = [
        'user_id',
        'opinion',
    ];

    use HasFactory;

    public static function submitOpinion($opinion)
    {
        return self::create([
            'user_id' => Auth::id(),
            'opinion' => $opinion,
        ]);
    }
}
