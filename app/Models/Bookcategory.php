<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookcategory extends Model
{
    use HasFactory;

    protected $table = 'bookcategories';

    protected $fillable  =[
      "categoryid",
      "categoryname",
    ]; 

    // Automatically generate the categoryid before creating a new record
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($bookcategory) {
            if (!$bookcategory->categoryid) {
                $bookcategory->categoryid = self::generateCategoryId();
            }
        });
    }
     // Generate the next categoryid in sequence
     public static function generateCategoryId()
     {
         // Get the last created category
         $lastCategory = self::orderBy('created_at', 'desc')->first();
 
         // If no category exists, start with BC-0001
         if (!$lastCategory) {
             return 'BC-0001';
         }
 
         // Extract the numeric part from the last categoryid
         $lastIdNumber = (int) substr($lastCategory->categoryid, 3);
 
         // Increment the numeric part and format it with leading zeros
         $newIdNumber = str_pad($lastIdNumber + 1, 4, '0', STR_PAD_LEFT);
 
         // Return the new categoryid
         return 'BC-' . $newIdNumber;
     }
}
