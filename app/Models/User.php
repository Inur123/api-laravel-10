<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'phone_number',
        'institution_code',
        'guardian_email',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke GirlyPedia melalui tabel pivot 'girly_pedia_user'
    public function girlyPediaItems()
    {
        return $this->belongsToMany(GirlyPedia::class, 'girly_pedia_user')
                    ->withPivot('is_completed')
                    ->withTimestamps();
    }
    public function podcasts()
    {
        return $this->belongsToMany(Podcast::class, 'podcast_user')
                    ->withPivot('is_completed') // Include pivot field
                    ->withTimestamps(); // If you have created_at and updated_at fields
    }
}
