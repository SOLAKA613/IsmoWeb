<?php

use App\Http\Controllers\dataController;
use Illuminate\Support\Facades\Route;
use App\Models\Time_planning;
use App\Models\Division;
use App\Models\Trainer;
use Illuminate\Support\Facades\Hash;
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

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

/*Route::get('/', function () {
    return view('welcome');}); */

Route::get('/index', 'SiteController@index');

//Connect and register

Route::get('/', function () {
    return view('connect.connect');
});

Route::post('/register_Conn', 'connectController@register_Conn');

Route::post('/connect', 'connectController@connect');

Route::get('/forgotPassword', function () {
    return view('connect.forgotPassword');
});

Route::get('/sendPassword', 'connectController@sendPassword');

Route::get('/out', 'connectController@out');

//Choice Division and level and groupe to show Trainnes

Route::get('/division', 'divisionController@listDivisions');

Route::post('/divisionController/fetch', 'divisionController@fetch')->name('divisionController.fetch');

Route::post('/divisionController/show', 'divisionController@show')->name('divisionController.show');

//Table and Operation Trainee

Route::get('/listTrainee', 'dataController@listTrainee');

Route::get('/add/{id?}', 'dataController@addUpdateTrainee');

Route::post('/addTrainee', 'dataController@addTrainee');

Route::get('/deleteTrainee', 'dataController@deleteTrainee')->name('dataController.delete');

Route::delete('/deleteLotTrainees', 'dataController@deleteLotTrainees')->name('dataController.deleteTrainees');

//Absence Trainee

Route::get('/hash',function(){dd( Hash::make('supervisor'));});

Route::post('/listAbsences_delays', 'traineeController@listAbsences_delay');

Route::get('/updateAbsence', 'traineeController@updateAbsence');

Route::delete('/deleteAbsence', 'traineeController@deleteAbsence');

Route::delete('/deleteLotAbsences', 'traineeController@deleteLotAbsences');

//Import file Excel content list of trainees

Route::get('/import_excel', function () {return view('ismo.admin.import_excelTrainees');});

Route::get('/choiceUpload', 'dataController@choiceUpload');

Route::post('/import_excel/import', 'dataController@import');

//Insert update ,delete list of divisions

Route::get('/listDivision', 'listController@listDivisions');

Route::put('/updateDivision', 'listController@updateDivision')->name('listControlle.updateDivision');

Route::delete('/deleteLotDivisions', 'listController@deleteLotDivisions');

Route::delete('/deleteDivision', 'listController@deleteDivision');

//Insert update ,delete levels

Route::get('/listLevel', 'listController@listLevels');

Route::get('/updateLevel', 'listController@updateLevel');

Route::get('/deleteLevel', 'listController@deleteLevel');

Route::delete('/deleteLotLevels', 'listController@deleteLotLevels');

//Insert update ,delete  groupes

Route::get('/listGroup', 'listController@listGroups');

Route::get('/updateGroup', 'listController@updateGroup');

Route::delete('/deleteGroup', 'listController@deleteGroup');

Route::delete('/deleteLotGroups', 'listController@deleteLotGroups');

//Insert update ,delete   modules

Route::get('/listModule', 'listController@listModules');

Route::get('/updateModule', 'listController@updateModule');

Route::delete('/deleteModule', 'listController@deleteModule');

Route::delete('/deleteLotModules', 'listController@deleteLotModules');

//Insert update ,delete Trainers

Route::get('/listTrainers', 'trainersController@listTrainers');

Route::get('/selectFile/{id}', 'trainersController@selectFile');

Route::get('/formTrainer/{id?}', 'moduleTrainerController@formTrainer');

Route::post('/moduleTrainerController/fetch', 'moduleTrainerController@fetch')->name('moduleTrainerController.fetch');

Route::get('/moduleTrainerController/show', 'moduleTrainerController@show')->name('moduleTrainerController.show');

Route::get('/listData', 'moduleTrainerController@listData');

Route::post('/addUpdateTrainer', 'moduleTrainerController@saveUpdate');

Route::get('/import_excelTrainers','trainersController@uploadExcel');

Route::get('/choiceAddUploadTrainer',function () {return view('ismo.TableData.Trainers.choiceAddUpload');});

Route::get('/deleteTrainer', 'trainersController@deleteTrainer')->name('trainersController.delete');

Route::delete('/deleteLotTrainers', 'trainersController@deleteLotTrainers');

// Route::get('/absences_delays', function () {return view('ismo.TableData.Trainee.absences_delays');});

Route::post('/import_excelTrainer/import', 'trainersController@import');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


