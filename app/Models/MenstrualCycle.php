<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenstrualCycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'last_period_start',
        'last_period_finish',
        'is_completed',
    ];
}
