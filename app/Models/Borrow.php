<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Borrow extends Model
{
    protected $fillable = [
        'student_id',
        'borrow_date',
        'due_date',
        'status',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function borrowItems()
    {
        return $this->hasMany(BorrowItem::class);
    }

    public function calculateFine()
    {
        if ($this->status === 'returned') {
            return 0;
        }

        $today = Carbon::today();
        $dueDate = Carbon::parse($this->due_date);

        if ($today->lte($dueDate)) {
            return 0;
        }

        $overdueDays = $today->diffInDays($dueDate);
        $unreturnedBooks = 0;
        
        foreach ($this->borrowItems as $item) {
            if ($item->quantity > $item->returned_quantity) {
                $unreturnedBooks += ($item->quantity - $item->returned_quantity);
            }
        }

        return 10 * $overdueDays * $unreturnedBooks;
    }

    public function isOverdue()
    {
        return Carbon::today()->gt($this->due_date) && $this->status !== 'returned';
    }

    public function updateStatus()
    {
        $allReturned = $this->borrowItems()
            ->whereRaw('quantity > returned_quantity')
            ->count() === 0;

        $partiallyReturned = $this->borrowItems()
            ->where('returned_quantity', '>', 0)
            ->whereRaw('quantity > returned_quantity')
            ->count() > 0;

        if ($allReturned) {
            $this->status = 'returned';
        } elseif ($partiallyReturned) {
            $this->status = 'partially_returned';
        } else {
            $this->status = 'borrowed';
        }

        $this->save();
    }
}
