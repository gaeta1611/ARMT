<?php

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
    return view('index');
});
Route::get('/login', function () {
    return view('login');
});


Route::resource('clients','ClientController');


Route::resource('missions','MissionController');
Route::get('/missions/create/{id?}','MissionController@create',['id'])
                        ->name('missions.create.from.client');


Route::resource('candidats','CandidatController');


Route::resource('candidatures','CandidatureController');

Route::resource('candidatures','CandidatureController');
Route::get('/candidatures/create/{id?}','CandidatureController@create',['id'])
                        ->name('candidatures.create.from.candidat');


Route::resource('prospects','ProspectController');
