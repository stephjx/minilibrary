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

        // Calculate percentage changes
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthStart = $lastMonth->copy()->startOfMonth();
        $lastMonthEnd = $lastMonth->copy()->endOfMonth();
        
        // Students growth (last 30 days vs previous 30 days)
        $studentsLast30Days = Student::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $studentsPrevious30Days = Student::whereBetween('created_at', [Carbon::now()->subDays(60), Carbon::now()->subDays(30)])->count();
        $studentsGrowth = $studentsPrevious30Days > 0 ? 
            round((($studentsLast30Days - $studentsPrevious30Days) / $studentsPrevious30Days) * 100, 1) : 0;

        // Books growth (last 30 days vs previous 30 days)
        $booksLast30Days = Book::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $booksPrevious30Days = Book::whereBetween('created_at', [Carbon::now()->subDays(60), Carbon::now()->subDays(30)])->count();
        $booksGrowth = $booksPrevious30Days > 0 ? 
            round((($booksLast30Days - $booksPrevious30Days) / $booksPrevious30Days) * 100, 1) : 0;

        // Borrows growth (this week vs last week)
        $borrowsThisWeek = Borrow::whereBetween('borrow_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $borrowsLastWeek = Borrow::whereBetween('borrow_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
        $borrowsGrowth = $borrowsLastWeek > 0 ? 
            round((($borrowsThisWeek - $borrowsLastWeek) / $borrowsLastWeek) * 100, 1) : 0;

        $recentBorrows = Borrow::with(['student'])
            ->latest()
            ->take(5)
            ->get();

        $popularBooks = Book::withCount('borrowItems')
            ->orderBy('borrow_items_count', 'desc')
            ->take(5)
            ->get();

        // Chart data for library activity (last 6 months)
        $chartData = $this->getChartData();

        return view('dashboard', compact(
            'totalStudents',
            'totalBooks',
            'availableBooks',
            'totalBorrows',
            'activeBorrows',
            'overdueBorrows',
            'totalFines',
            'studentsGrowth',
            'booksGrowth',
            'borrowsGrowth',
            'recentBorrows',
            'popularBooks',
            'chartData'
        ));
    }

    private function getChartData()
    {
        $monthlyData = [];
        $currentDate = Carbon::now();
        
        // Get data for the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $month = $currentDate->copy()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $borrowCount = Borrow::whereBetween('borrow_date', [$monthStart, $monthEnd])->count();
            
            $monthlyData[] = [
                'month' => $month->format('M Y'),
                'count' => $borrowCount
            ];
        }
        
        return $monthlyData;
    }
}
