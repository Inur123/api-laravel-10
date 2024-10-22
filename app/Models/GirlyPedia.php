<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GirlyPedia extends Model
{
    use HasFactory;

    protected $table = 'girly_pedia'; // Menentukan nama tabel

    protected $fillable = [
        'title',
        'description',
        'link',
        'user_id',
    ];


}
