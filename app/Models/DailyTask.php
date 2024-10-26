<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'challenge_id'];

    // Define the inverse relationship with the Challenge model
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
    public function userProgress()
    {
        return $this->hasMany(UserDailyTaskProgress::class);
    }
}
