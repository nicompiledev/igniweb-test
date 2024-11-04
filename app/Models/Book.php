<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Book Model: Represents a book entity.
 */
class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', // Book title
        'author', // Book author
        'description', // Book description
        'cover_book_url', // Book cover image URL (updated from 'image')
        'category', // Book category (stored as text)
    ];

    
}
