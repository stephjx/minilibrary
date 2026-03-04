<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\BorrowItem;
use App\Models\Student;
use App\Models\Book;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrow::with(['student', 'borrowItems.book']);
        
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('student', function($studentQuery) use ($searchTerm) {
                    $studentQuery->where('full_name', 'LIKE', '%' . $searchTerm . '%')
                              ->orWhere('student_number', 'LIKE', '%' . $searchTerm . '%');
                })
                ->orWhereHas('borrowItems.book', function($bookQuery) use ($searchTerm) {
                    $bookQuery->where('title', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }
        
        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $borrows = $query->latest()->paginate(10);
        
        return view('borrows.index', compact('borrows'));
    }

    public function create()
    {
        $students = Student::all();
        $books = Book::where('available_quantity', '>', 0)->get();
        return view('borrows.create', compact('students', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'due_date' => 'required|date|after_or_equal:today',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($validated['books'] as $bookItem) {
            $book = Book::find($bookItem['book_id']);
            if (!$book->isAvailable($bookItem['quantity'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Book '{$book->title}' does not have enough available copies.");
            }
        }

        $borrow = Borrow::create([
            'student_id' => $validated['student_id'],
            'borrow_date' => Carbon::today(),
            'due_date' => $validated['due_date'],
            'status' => 'borrowed',
        ]);

        foreach ($validated['books'] as $bookItem) {
            $book = Book::find($bookItem['book_id']);
            $book->decreaseAvailable($bookItem['quantity']);

            BorrowItem::create([
                'borrow_id' => $borrow->id,
                'book_id' => $bookItem['book_id'],
                'quantity' => $bookItem['quantity'],
                'returned_quantity' => 0,
            ]);
        }

        return redirect()->route('borrows.show', $borrow)
            ->with('success', 'Books borrowed successfully.');
    }

    public function show(Borrow $borrow)
    {
        $borrow->load(['student', 'borrowItems.book.authors']);
        $fine = $borrow->calculateFine();
        return view('borrows.show', compact('borrow', 'fine'));
    }

    public function returnBooks(Request $request, Borrow $borrow)
    {
        $validated = $request->validate([
            'returns' => 'required|array|min:1',
            'returns.*.borrow_item_id' => 'required|exists:borrow_items,id',
            'returns.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($validated['returns'] as $returnItem) {
            $borrowItem = BorrowItem::find($returnItem['borrow_item_id']);
            
            if ($borrowItem->borrow_id !== $borrow->id) {
                continue;
            }

            if ($returnItem['quantity'] > $borrowItem->remaining_quantity) {
                return redirect()->back()
                    ->with('error', 'Cannot return more books than borrowed.');
            }

            $borrowItem->returnBooks($returnItem['quantity']);
        }

        return redirect()->route('borrows.show', $borrow)
            ->with('success', 'Books returned successfully.');
    }

    public function destroy(Borrow $borrow)
    {
        if ($borrow->status !== 'returned') {
            return redirect()->route('borrows.index')
                ->with('error', 'Cannot delete active borrow.');
        }

        $borrow->borrowItems()->delete();
        $borrow->delete();

        return redirect()->route('borrows.index')
            ->with('success', 'Borrow record deleted successfully.');
    }
}
