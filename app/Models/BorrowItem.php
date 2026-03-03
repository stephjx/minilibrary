<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowItem extends Model
{
    protected $fillable = [
        'borrow_id',
        'book_id',
        'quantity',
        'returned_quantity',
    ];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function getRemainingQuantityAttribute()
    {
        return $this->quantity - $this->returned_quantity;
    }

    public function isFullyReturned()
    {
        return $this->returned_quantity >= $this->quantity;
    }

    public function returnBooks($quantity)
    {
        if ($quantity > $this->remaining_quantity) {
            throw new \Exception('Cannot return more books than borrowed');
        }

        $this->increment('returned_quantity', $quantity);
        $this->book->increaseAvailable($quantity);
        $this->borrow->updateStatus();
    }
}
