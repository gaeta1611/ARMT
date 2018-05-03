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

Route::middleware('auth:api')->group(function () {
    
    Route::get('/search', 'HomeController@search');
    Route::get('/status', 'StatusController@getAll');
    Route::get('/information_candidature', 'InformationCandidatureController@getAll');
    Route::get('/mode_reponse', 'ModeReponseController@getAll');
    Route::get('/localite/cp/{cp}', 'LocaliteController@getLocaliteFromCP',['cp'])->middleware('cors');
    Route::get('/localite/ville/{localite}', 'LocaliteController@getCPFromLocalite',['localite']);
    Route::get('/candidat/status', 'CandidatController@index');
    Route::get('/candidat/{nom}/{prenom}', function(Request $request) {
        return App\Candidat::where('nom','=',$request['nom'])
        ->where('prenom','=',$request['prenom'])->get();
    });
    Route::get('/diplome', 'DiplomeController@findDiplome');

    Route::post('/candidatures/{id}','CandidatureController@update',['id']);
    Route::post('/interviews/{idCandidature}','InterviewController@updateStoreFor',['idCandidature']);
    Route::put('/jobs/{idCandidat}','CandidatSocieteController@storeFor',['idCandidat']);
    Route::delete('/jobs/{id}','CandidatSocieteController@storeFor',['id']);
    Route::post('/diplome','DiplomeController@store');
    Route::post('/ecole','EcoleController@store');
    Route::post('/diplomes_ecoles','DiplomeEcoleController@store');
    Route::post('/societe','SocieteController@store');
    Route::post('/fonction','FonctionController@store');

});


