<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/status', 'StatusController@getAll');
Route::get('/information_candidature', 'InformationCandidatureController@getAll');
Route::get('/mode_reponse', 'ModeReponseController@getAll');
Route::get('/localite/cp/{cp}', 'LocaliteController@getLocaliteFromCP',['cp']);
Route::get('/localite/ville/{localite}', 'LocaliteController@getLocaliteFromLocalite',['localite']);

Route::post('/candidatures/{id}','CandidatureController@update',['id']);
Route::post('/interviews/{idCandidature}','InterviewController@updateStoreFor',['idCandidature']);



