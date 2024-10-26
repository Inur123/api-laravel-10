<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GirlyPedia extends Model
{
    use HasFactory;

    protected $table = 'girly_pedia';

    protected $fillable = ['title', 'description', 'link', 'image'];

    // Tambahkan relasi users dengan menggunakan tabel pivot 'girly_pedia_user'
    public function users()
    {
        return $this->belongsToMany(User::class, 'girly_pedia_user')
                    ->withPivot('is_completed')
                    ->withTimestamps();
    }
}
