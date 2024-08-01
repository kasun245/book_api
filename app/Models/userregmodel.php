<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userregmodel extends Model
{
    use HasFactory;

    protected $table = 'usertable';

    protected $fillable  =[
      "userid",
      "username",
      "usermobileno",
      "email",
      "password",
      "date",
      "time",
      "usertype",
    ]; 
}
