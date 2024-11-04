<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Nombre de la categoría
    ];

    /**
     * Obtener los libros que pertenecen a esta categoría.
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
