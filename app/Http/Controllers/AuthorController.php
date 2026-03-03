<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->paginate(10);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id,
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
