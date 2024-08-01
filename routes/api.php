<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\BookTypesController;
use App\Http\Controllers\Api\userRegController;
use App\Http\Controllers\BookcategoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// posts routes
Route::group(['prefix' => 'auth'], function () {
  Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('books/getSelectedBook', [BookController::class, 'getSelectedBook']);

    
    Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('checkUser', [UserCheck::class, 'checkUser']);

    Route::post('books', [BookController::class, 'store']);
    Route::post('/books/pending', [BookController::class, 'getPendingBooks']);
    Route::post('books/getCompleteBooks', [BookController::class, 'getCompleteBook']);
    Route::put('books/{book}', [BookController::class, 'update']);
    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{book}', [BookController::class, 'show']);
    Route::delete('books/{book}', [BookController::class, 'destroy']);
    Route::post('getallCategoryTypes', [BookcategoryController::class, 'getCategoryAndTypes']);
    Route::post('createBookCategory', [BookcategoryController::class, 'createNewCategory']);
    Route::post('getAllBookTypes', [BookTypesController::class, 'getBookAllBookTypes']);
    Route::post('createBookType', [BookTypesController::class, 'createNewBookType']);

    //chats
    Route::post('/chats', [ChatController::class, 'store']);
    Route::get('/chats', [ChatController::class, 'index']);
    Route::post('/chats/{chat}/messages', [MessageController::class, 'store']);
    Route::get('/chats/{chat}/messages', [MessageController::class, 'index']);
  });
});
//Route::post('register', [AuthController::class, 'register']);
//Route::post('customer',[userRegController::class,'usercreatecontroller']);