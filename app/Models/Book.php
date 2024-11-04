<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'cover_book_url', // Cambié 'image' a 'cover_book_url' para que coincida con tu comando
        'category', // Almacena la categoría como texto
    ];

    // Ya no necesitas este método porque no hay relación con Category
}
