<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', // Foreign key referencing the user
        'book_id', // Foreign key referencing the book
        'start_date', // Reservation start date
        'end_date', // Reservation end date
    ];

    /**
     * Relationship with the reserved book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Relationship with the user who made the reservation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Validation rules for the reservation.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    /**
     * Validates the reservation data.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validate(array $data)
    {
        return Validator::make($data, static::rules());
    }
}
