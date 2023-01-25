<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    dd(\Illuminate\Support\Facades\Session::all());
    return view('welcome');
});

Route::get('/home', [\App\Http\Controllers\UIController::class, 'home']);

Route::get('/Mockups/Quiz', [\App\Http\Controllers\UIController::class, 'startQuiz']);

Route::get('/Mockups/Quiz/Result', [\App\Http\Controllers\UIController::class, 'getQuizResult']);





