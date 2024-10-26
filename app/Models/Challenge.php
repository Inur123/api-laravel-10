<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    // Define the one-to-many relationship with DailyTask
    public function dailyTasks()
    {
        return $this->hasMany(DailyTask::class);
    }

}
