<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Agregar esta línea
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail // Implementar la interfaz
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', // Asegúrate de que el campo sea 'username' en lugar de 'name'
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Obtener las reservas del usuario.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
