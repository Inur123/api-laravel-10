<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    protected $fillable = ['challenge_id', 'description', 'is_completed'];

    // Relasi Many-to-One dengan Challenge
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
