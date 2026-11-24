<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->search;

        $books = Book::with('category')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', $keyword)
                      ->orWhere('author', $keyword);
            })
            ->when($request->kategori, function ($query) use ($request) {
                $query->where('category_id', $request->kategori);
            })
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('books.index', compact('categories') + ['hasilBuku' => $books]);
    }
}
