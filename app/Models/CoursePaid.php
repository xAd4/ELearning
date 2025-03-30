<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePaid extends Model
{
    use HasFactory;

    protected $fillable = [
        "courses_paid_id",
        "course_id",
    ];

    public function coursespaid()
    {
        return $this->belongsTo(CoursesPaid::class);
    }
}
