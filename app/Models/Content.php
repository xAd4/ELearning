<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        "section_id",
        "title",
        "file_path", // pdf, .zip, mp4
        "order",
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
