<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
Route::post('/reg', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

// Public.
// Table for show all data in database.
Route::get('/product', [\App\Http\Controllers\ProductController::class, 'index']);
// Show Data in database with ID.
Route::get('/product/show/{id}', [\App\Http\Controllers\ProductController::class, 'show']);
// Show Data in database with Name.
Route::get('/product/search/{name}', [\App\Http\Controllers\ProductController::class, 'search']);

// Private, you must Login for use it.
// Insert data to database.
Route::middleware('auth:sanctum')->post('/product/store', [\App\Http\Controllers\ProductController::class, 'store']);
// Update data in database.
Route::middleware('auth:sanctum')->post('/product/update/{id}', [\App\Http\Controllers\ProductController::class, 'update']);
// Delete data in database.
Route::middleware('auth:sanctum')->delete('/product/delete/{id}', [\App\Http\Controllers\ProductController::class, 'delete']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
