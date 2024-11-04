<?php

// En App\Models\Reservation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Referencia al usuario
        'book_id', // Referencia al libro
        'start_date', // Fecha de inicio de la reserva
        'end_date', // Fecha de finalización de la reserva
    ];

    /**
     * Obtener el libro que se ha reservado.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Obtener el usuario que ha hecho la reserva.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
