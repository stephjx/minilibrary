<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\BorrowItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalBooks = Book::sum('total_quantity');
        $availableBooks = Book::sum('available_quantity');
        $totalBorrows = Borrow::count();
        $activeBorrows = Borrow::whereIn('status', ['borrowed', 'partially_returned'])->count();
        
        $overdueBorrows = Borrow::where('due_date', '<', Carbon::today())
            ->whereIn('status', ['borrowed', 'partially_returned'])
            ->count();

        $totalFines = 0;
        $overdueBorrowRecords = Borrow::where('due_date', '<', Carbon::today())
            ->whereIn('status', ['borrowed', 'partially_returned'])
            ->get();

        foreach ($overdueBorrowRecords as $borrow) {
            $totalFines += $borrow->calculateFine();
        }

        $recentBorrows = Borrow::with(['student'])
            ->latest()
            ->take(5)
            ->get();

        $popularBooks = Book::withCount('borrowItems')
            ->orderBy('borrow_items_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalBooks',
            'availableBooks',
            'totalBorrows',
            'activeBorrows',
            'overdueBorrows',
            'totalFines',
            'recentBorrows',
            'popularBooks'
        ));
    }
}
