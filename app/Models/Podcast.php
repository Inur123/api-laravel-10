<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi
    protected $fillable = [
        'user_id',      // ID pengguna yang membuat podcast
        'title',        // Judul podcast
        'description',  // Deskripsi podcast
        'link',         // Tautan ke podcast
    ];

    // Definisikan hubungan dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

