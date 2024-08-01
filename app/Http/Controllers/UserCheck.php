<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserCheck extends Controller
{
    //
    public function checkUser(Request $request)
    {
        if(User::where('email', $request->email)->exists()){
            return response()->json([
                'result' => 'success',
                'message' => 'This user ' .$request->email. ' account exist',
                'boolean' => true
            ], 200);
        }
        else{
            return response()->json([
                'result' => 'error',
                'message' => 'This user ' .$request->email. ' account doesnot exist. Please sign up and try again.',
                'boolean' => false
            ], 401); 
        }

    }
}
