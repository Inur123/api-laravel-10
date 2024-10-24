<?php

// app/Models/Challenge.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'progress'];

    // Relasi One-to-Many dengan Daily
    public function dailies()
    {
        return $this->hasMany(Daily::class);
    }
}
