<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
/*
|-----
---------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/adminlog',[AdminController::class,'adminlog']);
Route::post('/profile',[AdminController::class,'profile']);
Route::post('/adminregister', [AdminController::class, 'adminregister']);
Route::post('/register',[AdminController::class,'register']);
Route::post('/checkotp', [AdminController::class, 'checkotp']);
Route::post('/update', [AdminController::class, 'update']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
