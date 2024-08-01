<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'book_name', 'email', 'author_name', 'book_type', 'book_category', 'conclusion', 'cover_picture', 'finish_date', 'modify_date', 'book_title', 'status'
    ];

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
