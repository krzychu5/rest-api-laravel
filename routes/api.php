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
Route::group(['namespace'=>'\App\Http\Controllers'], function(){
  Route::get('/get-ticket', 'TicketController@index')->name('ticket-index');
  Route::get('/ticket/{id}', 'TicketController@show')->name('ticket-show');
  Route::post('/register', 'AuthController@register')->name('register');
  Route::post('/login', 'AuthController@login')->name('login');
  // Route::put('/ticket/{id}', 'TicketController@update')->name('ticket-update');


});

Route::group(['namespace'=>'\App\Http\Controllers', 'middleware'=>['auth:sanctum']], function(){
  Route::post('/post-ticket', 'TicketController@store')->name('ticket-store');
  Route::put('/ticket/{id}', 'TicketController@update')->name('ticket-update');
  Route::delete('/ticket/{id}', 'TicketController@destroy')->name('ticket-destroy');
  Route::post('/logout', 'AuthController@logout')->name('logout');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
