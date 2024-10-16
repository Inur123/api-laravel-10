<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenstrualCycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cycle_duration',
        'last_period_start',
        'gap_days',
    ];
}
