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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login','Api\AuthController@login');
Route::get('filieres','Api\AuthController@divisions');
Route::post('insertImageTrainee','Api\AuthController@InsertImageTrainee');
Route::get('niveaux','Api\TrainerController@levels');
Route::get('groupes','Api\TrainerController@groups');
Route::get('stagiaires','Api\TrainerController@stagiaires');
Route::get('absences','Api\TrainerController@absences');
