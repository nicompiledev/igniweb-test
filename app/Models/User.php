<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Agregar esta línea
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model: Represents an application user.
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', // Unique username
        'email', // User email
        'password', // User password
    ];

    /**
     * Hidden attributes from API responses.
     *
     * @var array
     */
    protected $hidden = [
        'password', // Secure password
        'remember_token', // Secure token
    ];

    /**
     * Attribute casts.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Verify email timestamp
            'password' => 'hashed', // Hashed password
        ];
    }

    /**
     * Retrieves user reservations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
