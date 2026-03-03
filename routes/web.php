<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BorrowController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('students', StudentController::class);
    Route::resource('books', BookController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('borrows', BorrowController::class)->except(['edit', 'update']);
    
    Route::post('/borrows/{borrow}/return', [BorrowController::class, 'returnBooks'])
        ->name('borrows.return');
});

require __DIR__.'/auth.php';
