<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        "category_id",
        "user_id",
        "img",
        "title",
        "description",
        "price",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->hasMany(Section::class);
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }

    public function qandq()
    {
        return $this->hasMany(QAndQ::class);
    }
}
