<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import AuthController.
use \App\Http\Controllers\AuthController;

// Import ProductController.
use \App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth
Route::post('/reg', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public.
// Table for show all data in database.
Route::get('/product', [ProductController::class, 'index']);
// Show Data in database with ID.
Route::get('/product/show/{id}', [ProductController::class, 'show']);
// Show Data in database with Name.
Route::get('/product/search/{name}', [ProductController::class, 'search']);

// Private, you must Login for use it.
// Group middleware [auth:sanctum]
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Insert data to database.
    Route::post('/product/store', [ProductController::class, 'store']);
    // Update data in database.
    Route::post('/product/update/{id}', [ProductController::class, 'update']);
    // Delete data in database.
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete']);

    //Auth
    // Logout and delete tokens
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Get User
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
