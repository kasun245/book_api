<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;




class AuthController extends Controller
{

    // public function register(Request $request)
    // {
    //     // $request->validate([
    //     //     'name' => 'required|string',
    //     //     'mobile_no' => 'required|min:10|numeric',
    //     //     'address' => 'required|string',
    //     //     'email' => 'required|string|email|max:255',
    //     //     'password' => 'required|string|min:6',
    //     //     'c_password' => 'required|same:password'
    //     // ]);

    //     $credentials = request([
    //         'email' => 'required|string|email|max:255',
    //          'password'=> 'required|string|min:6',
    //           'mobile_no'=> 'required|min:10|numeric',
    //     ]);
    //     if(auth()->attempt($credentials)){
    //         return response()->json([
    //             'message' => 'The given data was invalid.',
    //             'errors' => [
    //                 'email' => ['invalid email.'],
    //                 'password' => ['invalid password.'],
    //                 'mobile_no' => ['invalid mobile no.'],
    //                 'address' => ['Address id requred.'],
    //             ],
    //         ], status:422);
    //     }


    //     if (User::where('email', $request->email)->exists()) {
    //         return response()->json([
    //             'message' => 'This email ' .$request->email.' has already been registered. Please try a different email address.'
    //         ], 409);
    //     }
    //     else{

    //     $user = new User([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'mobile_no' => $request->mobile_no,
    //         'address' => $request->address,
    //         'password' => bcrypt($request->password),
    //     ]);


    //     if ($user->save()) {
    //         $tokenResult = $user->createToken('Personal Access Token');
    //         $token = $tokenResult->plainTextToken;

    //         return response()->json([
    //             'message' => 'Successfully created user!',
    //             'accessToken' => $token,
    //             'user_info'=> $user,
    //         ], 201);
    //     } else {
    //         return response()->json(['error' => 'Provide proper details'], 400);
    //     }
    //  }
    // }
    //kausn 
    // public function register(Request $request)
    // {
    //     // Define the validation rules
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string',
    //         'mobile_no' => 'required|string|min:10|numeric',
    //         'address' => 'required|string',
    //         'email' => 'required|string|email|max:255|unique:users,email',
    //         'password' => 'required|string|min:6',
    //         'c_password' => 'required|same:password'
    //     ]);

    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => 'The given data was invalid.',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }
    //     $user = new User([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'mobile_no' => $request->mobile_no,
    //         'address' => $request->address,
    //         'password' => bcrypt($request->password),
    //     ]);

    //     // Save the user
    //     if ($user->save()) {
    //         // Generate a personal access token
    //         $tokenResult = $user->createToken('Personal Access Token');
    //         $token = $tokenResult->plainTextToken;

    //         return response()->json([
    //             'message' => 'Successfully created user!',
    //             'accessToken' => $token,
    //             'user' => $user
    //         ], 201);
    //     } else {
    //         return response()->json(['error' => 'Provide proper details'], 400);
    //     }
    // }
    
    //dimmithra
    public function register(Request $request)
    {
        $data = $request->all();

        // Check 'name' field
        if (!isset($data['name']) || empty($data['name'])) {
            return response()->json(['result' => 'fail', 'message' => 'Name is required.','accessToken' => ''], 422);
        } elseif (!is_string($data['name'])) {
            return response()->json(['result' => 'fail', 'message' => 'Name must be a string.','accessToken' => ''], 422);
        }

        // Check 'mobile_no' field
        if (!isset($data['mobile_no']) || empty($data['mobile_no'])) {
            return response()->json(['result' => 'fail', 'message' => 'Mobile number is required.','accessToken' => ''], 422);
        } elseif (strlen($data['mobile_no']) < 10) {
            return response()->json(['result' => 'fail', 'message' => 'Mobile number must be at least 10 characters.','accessToken' => ''], 422);
        } elseif (!is_numeric($data['mobile_no'])) {
            return response()->json(['result' => 'fail', 'message' => 'Mobile number must be numeric.','accessToken' => ''], 422);
        }

        // Check 'address' field (optional)
        if (isset($data['address']) && !is_string($data['address'])) {
            return response()->json(['result' => 'fail', 'message' => 'Address must be a string.','accessToken' => ''], 422);
        }

        // Check 'email' field
        if (!isset($data['email']) || empty($data['email'])) {
            return response()->json(['result' => 'fail', 'message' => 'Email is required.','accessToken' => ''], 422);
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return response()->json(['result' => 'fail', 'message' => 'Invalid email format.','accessToken' => ''], 422);
        } elseif (strlen($data['email']) > 255) {
            return response()->json(['result' => 'fail', 'message' => 'Email must not exceed 255 characters.' ,'accessToken' => ''], 422);
        } elseif (User::where('email', $data['email'])->exists()) {
            return response()->json(['result' => 'fail', 'message' => 'Email already exists.' ,'accessToken' => ''], 422);
        }

        // Check 'password' field
        if (!isset($data['password']) || empty($data['password'])) {
            return response()->json(['result' => 'fail', 'message' => 'Password is required.' ,'accessToken' => ''], 422);
        } elseif (strlen($data['password']) < 6) {
            return response()->json(['result' => 'fail', 'message' => 'Password must be at least 6 characters.' ,'accessToken' => ''], 422);
        }

        // Check 'c_password' field
        if (!isset($data['c_password']) || empty($data['c_password'])) {
            return response()->json(['result' => 'fail', 'message' => 'Confirm password is required.' ,'accessToken' => ''], 422);
        } elseif ($data['c_password'] !== $data['password']) {
            return response()->json(['result' => 'fail', 'message' => 'Passwords do not match.' ,'accessToken' => ''], 422);
        }

        // If no errors, create the user
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'password' => bcrypt($request->password),
        ]);

    // Save the user
    if ($user->save()) {
        // Generate a personal access token
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'result' => 'success',
            'message' => 'Successfully created user.',
            'accessToken' => $token
        ], 200);
        } else {
            return response()->json(['result' => 'fail', 'message' => 'Provide proper details'], 400);
        }
    }




    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     */

public function login(Request $request)
    {
    // Validate the request inputs
    $request->validate([
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:6',
        'remember_me' => 'boolean'
    ]);

    // Attempt to authenticate the user with the provided credentials
    $credentials = $request->only('email', 'password');
    if (!auth()->attempt($credentials)) {
        
        return response()->json([
            'result' => 'fail',
            'message' => 'Invalide User Name or password',
            'accessToken' => "",
            'token_type' => '',
            // 'message' => 'Unauthorized'
        ], 401);
    }

    // Authentication passed, get the authenticated user
    $user = $request->user();
    
    // Create a personal access token for the user
    $tokenResult = $user->createToken('Personal Access Token');
    $token = $tokenResult->plainTextToken;

    // Return the access token
    return response()->json([
        'result' => 'success',
        'message' => 'Login success',
        'accessToken' => $token,
        'token_type' => 'Bearer',
    ],200);
}

     

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    // public function logout(Request $request)
    // {
    //     $request->user()->tokens()->delete();

    //     return response()->json(['result' => 'success', 'message' => 'Successfully logged out' ,'response' => '200'],200);
    //     // json([
    //     //     'message' => 'Successfully logged out  user'
    //     // ]);
    // }

    public function logout(Request $request)
{
    try {
        // Attempt to delete all tokens associated with the authenticated user
        $request->user()->tokens()->delete();

        // Respond with a success message
        return response()->json([
            'result' => 'success',
            'message' => 'Successfully logged out',
            'response_code' => 200
        ], 200);
    } catch (\Exception $e) {
        // Log the exception for debugging purposes
        //Log::error('Logout error: ' . $e->getMessage());

        // Respond with an error message
        return response()->json([
            'result' => 'error',
            'message' => 'Failed to log out. Please try again.',
            'response_code' => 500
        ], 500);
    }
}


    /**
     * Get the authenticated User
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
