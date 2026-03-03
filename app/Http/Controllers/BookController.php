<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('authors')->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books',
            'total_quantity' => 'required|integer|min:1',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
        ]);

        $book = Book::create([
            'title' => $validated['title'],
            'isbn' => $validated['isbn'],
            'total_quantity' => $validated['total_quantity'],
            'available_quantity' => $validated['total_quantity'],
        ]);

        $book->authors()->attach($validated['authors']);

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        $book->load('authors', 'borrowItems.borrow.student');
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $book->load('authors');
        return view('books.edit', compact('book', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'total_quantity' => 'required|integer|min:1',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
        ]);

        $borrowedQuantity = $book->total_quantity - $book->available_quantity;
        
        if ($validated['total_quantity'] < $borrowedQuantity) {
            return redirect()->route('books.edit', $book)
                ->with('error', 'Total quantity cannot be less than borrowed quantity.');
        }

        $book->update([
            'title' => $validated['title'],
            'isbn' => $validated['isbn'],
            'total_quantity' => $validated['total_quantity'],
            'available_quantity' => $validated['total_quantity'] - $borrowedQuantity,
        ]);

        $book->authors()->sync($validated['authors']);

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->borrowItems()->whereRaw('quantity > returned_quantity')->exists()) {
            return redirect()->route('books.index')
                ->with('error', 'Cannot delete book with active borrows.');
        }

        $book->authors()->detach();
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }
}
