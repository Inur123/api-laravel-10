<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PodcastUser extends Pivot
{
    use HasFactory;

    protected $table = 'podcast_user';

    protected $fillable = [
        'user_id',
        'podcast_id',
        'is_completed',
        'progress',
    ];

    // Define relationships if needed
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }



}
