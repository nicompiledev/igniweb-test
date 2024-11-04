<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los libros paginados, ajusta el número de elementos por página como prefieras
        $books = Book::paginate(8); // Cambia 10 por el número de elementos por página que desees

        // Obtener categorías únicas
        $categories = $books->pluck('category')->unique();

        return view('books.index', compact('books', 'categories'));
    }

    public function filter(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $query = Book::query();

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Obtener libros paginados
        $books = $query->paginate(10); // Cambia 10 por el número de elementos por página que desees
        // Opción para que la paginación funcione con AJAX
        $books->withPath('/books/filter?category=' . $category . '&search=' . $search);

        return response()->json($books);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id); // Ajusta según tu lógica de búsqueda
        return response()->json($book);
    }
}
