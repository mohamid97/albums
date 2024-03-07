<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('album.index');
});


// start albums trask route 
Route::namespace('App\Http\Controllers\Albums')->group(function(){
    Route::resource('/album', 'AlbumController');
    Route::prefix('album')->group(function(){
       Route::get('/move/images/{album}' , 'AlbumController@move')->name('album.move');
       Route::post('/album/move' , 'AlbumController@move_update')->name('album.move_update');
    });
});


