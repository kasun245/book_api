<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'page_no',
        'page_subtitle',
        'page_details',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
