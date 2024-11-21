<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

/**
 * Controller for managing books.
 */
class BookController extends Controller
{
    /**
     * Display a listing of the books.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
{
    // Retrieve paginated books
    $books = Book::paginate(8); // Cambia 8 por el número deseado de elementos por página

    // Retrieve all unique categories
    $categories = Book::whereNotNull('category')->distinct()->pluck('category');

    return view('books.index', compact('books', 'categories'));
}


    /**
     * Filter books by category and search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */



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

    $books = $query->paginate(8);

    return response()->json([
        'data' => $books->items(),
        'pagination' => [
            'current_page' => $books->currentPage(),
            'last_page' => $books->lastPage(),
            'next_page_url' => $books->nextPageUrl(),
            'prev_page_url' => $books->previousPageUrl(),
            'links' => $books->links('pagination::bootstrap-4')->toHtml(),
        ],
        'categories' => Book::whereNotNull('category')->distinct()->pluck('category'), // Opcional: Devuelve las categorías para mantener actualizada la lista
    ]);
}


    /**
     * Display the specified book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }
}
