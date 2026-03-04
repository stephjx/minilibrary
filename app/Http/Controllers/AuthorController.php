<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::withCount('books');

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Date filter functionality
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }

        $authors = $query->paginate(5);
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors',
        ]);

        Author::create($validated);

        return redirect()->route('authors.index')
            ->with('success', 'Author created successfully.');
    }

    public function show(Author $author)
    {
        $author->load('books');
        return view('authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        // Handle modal submission with author_id parameter
        if ($request->has('author_id') && $request->input('author_id') != $author->id) {
            $author = Author::findOrFail($request->input('author_id'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id,
            'email' => 'nullable|email|max:255|unique:authors,email,' . $author->id,
            'bio' => 'nullable|string|max:1000',
        ]);

        $author->update($validated);

        return redirect()->route('authors.index')
            ->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        if ($author->books()->exists()) {
            return redirect()->route('authors.index')
                ->with('error', 'Cannot delete author with associated books.');
        }

        $author->delete();

        return redirect()->route('authors.index')
            ->with('success', 'Author deleted successfully.');
    }
}
