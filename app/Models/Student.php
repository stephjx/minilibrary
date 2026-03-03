<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_number',
        'full_name',
        'course',
        'year_level',
    ];

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
