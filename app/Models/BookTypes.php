<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTypes extends Model
{
    use HasFactory;

    protected $table = 'bookTypes';

    protected $fillable  =[
        "booktypeid",
        "booktypename",
    ];


    // Automatically generate the categoryid before creating a new record
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booktype) {
            if (!$booktype->booktypeid) {
                $booktype->booktypeid = self::generateBookTypeId();
            }
        });
    }
     // Generate the next categoryid in sequence
     public static function generateBookTypeId()
     {
         // Get the last created category
         $lastBookType = self::orderBy('created_at', 'desc')->first();
 
         // If no category exists, start with BC-0001
         if (!$lastBookType) {
             return 'BT-0001';
         }
 
         // Extract the numeric part from the last categoryid
         $lastIdNumber = (int) substr($lastBookType->booktypeid, 3);
 
         // Increment the numeric part and format it with leading zeros
         $newIdNumber = str_pad($lastIdNumber + 1, 4, '0', STR_PAD_LEFT);
 
         // Return the new categoryid
         return 'BT-' . $newIdNumber;
     }
}
