<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GirlyPediaUser extends Model
{
    use HasFactory;

    protected $table = 'girly_pedia_user'; // Specify the correct table name

    protected $fillable = [
        'user_id',
        'girly_pedia_id',
        'is_completed',
    ];
}
