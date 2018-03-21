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
Route::get('/candidat/status', 'CandidatController@index',['localite']);
//Route::get('/diplome', 'DiplomeController@findDiplomeEcole',['formData']);
Route::get('/diplome', 'DiplomeController@findDiplome');

Route::post('/candidatures/{id}','CandidatureController@update',['id']);
Route::post('/interviews/{idCandidature}','InterviewController@updateStoreFor',['idCandidature']);
Route::put('/jobs/{idCandidat}','CandidatSocieteController@storeFor',['idCandidat']);
Route::delete('/jobs/{id}','CandidatSocieteController@storeFor',['id']);
Route::post('/diplome','DiplomeController@store');
Route::post('/ecole','EcoleController@store');
Route::post('/diplomes_ecoles','DiplomeEcoleController@store');




