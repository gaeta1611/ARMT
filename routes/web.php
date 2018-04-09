<?php

use Illuminate\Http\Request;

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

Route::get('/', 'HomeController@index')->name('home');


Route::resource('clients','ClientController');

Route::resource('missions','MissionController');
Route::get('/missions/create/{id?}','MissionController@create',['id'])
                        ->name('missions.create.from.client');


Route::get('candidats/search','CandidatController@search')
                        ->name('candidats.search');
Route::get('candidats/searchBy','CandidatController@searchBy')
                        ->name('candidats.searchBy');
Route::resource('candidats','CandidatController');


Route::resource('candidatures','CandidatureController');
Route::get('/candidatures/create/{id?}','CandidatureController@create',['id'])
                        ->name('candidatures.create.from.candidat');





Auth::routes();

Route::put('register/{id}','Auth\\RegisterController@update',['id'])
        ->name('profile.update');
Route::resource('users','UserController');

Route::get('/language/{lang}', function($lang){
        session(['lang'=>$lang]);

        return back();
});

