<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PodcastController::class)->group(function(){
  Route::get('index');
});

Route::controller(AuthController::class)->group(function(){
  Route::post('register','register');
  Route::post('login','login');
  Route::post('logout','logout')->middleware('auth:sanctum');
  Route::put('reset/password/{id}','restPassword');
});

Route::middleware('auth:sanctum')->group(function(){
  Route::get('users',[UserController::class,'index']);
  Route::post('users/create',[UserController::class,'store']);
  Route::get('users/show/{id}',[UserController::class,'show']);
  Route::put('users/update/{id}',[UserController::class,'update']);
  Route::delete('users/delete/{id}',[UserController::class,'destroy']);

  Route::controller(PodcastController::class)->group(function(){
    Route::get('podcasts','index');
    Route::post('podcasts/create','store');
    Route::get('podcasts/my-podcast','show');
  });
});