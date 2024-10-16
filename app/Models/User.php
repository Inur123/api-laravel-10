<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Import this

class User extends Authenticatable
{
    use HasApiTokens, Notifiable; // Add HasApiTokens here

    // Include the new fields in the fillable array
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',      // Added date of birth
        'phone_number',       // Added phone number
        'institution_code',   // Added institution code (optional)
        'guardian_email',     // Added guardian email (optional)
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // You can also define any additional methods or relationships here if needed
}
