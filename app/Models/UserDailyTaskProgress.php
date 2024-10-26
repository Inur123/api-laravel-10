<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDailyTaskProgress extends Model
{
    use HasFactory;

    protected $fillable = ['daily_task_id', 'user_id', 'is_completed', 'challenge_id','progress_percentage'];

    public function dailyTask()
    {
        return $this->belongsTo(DailyTask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
