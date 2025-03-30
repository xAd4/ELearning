<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QAndQ extends Model
{
    use HasFactory;

    protected $table = "q_and_q_s";

    protected $fillable = [
        "user_id",
        "course_id",
        "title",
        "description",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function response()
    {
        return $this->hasMany(Response::class);
    }
}
