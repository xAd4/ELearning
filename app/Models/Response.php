<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "qandq_id",
        "description",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function qandq()
    {
        return $this->belongsTo(QAndQ::class);
    }
}
