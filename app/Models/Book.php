<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'isbn',
        'total_quantity',
        'available_quantity',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_book');
    }

    public function borrowItems()
    {
        return $this->hasMany(BorrowItem::class);
    }

    public function isAvailable($quantity = 1)
    {
        return $this->available_quantity >= $quantity;
    }

    public function decreaseAvailable($quantity)
    {
        $this->decrement('available_quantity', $quantity);
    }

    public function increaseAvailable($quantity)
    {
        $this->increment('available_quantity', $quantity);
    }
}
