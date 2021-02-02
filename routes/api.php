<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CreditController;

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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::get('myCredit', [CreditController::class, 'check'])->middleware('jwt.verify');
Route::get('myProfile', [CreditController::class, 'account'])->middleware('jwt.verify');
Route::get('myHistory', [CreditController::class, 'history'])->middleware('jwt.verify');
Route::get('sortHistory/{param}', [CreditController::class, 'sort'])->middleware('jwt.verify');
Route::put('updateTransaction/{id}', [CreditController::class, 'update'])->middleware('jwt.verify');
Route::post('addTransaction', [CreditController::class, 'add'])->middleware('jwt.verify');
Route::delete('deleteTransaction/{id}', [CreditController::class, 'delete'])->middleware('jwt.verify');
