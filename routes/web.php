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

// Auth::routes();

// Route::get('/home', 'Auth/LoginController@index');
Route::get('jobfit/{session_id}', 'HomeController@index')->name('home');

//Route::group(['middleware' => ['session']], function(){
	Route::get('/', 'ResultController@index');
	Route::post('logout', 'HomeController@logout');

	// Route::get('/home', 'Auth/LoginController@index');
	Route::resource('quadranCompetencies', 'QuadranCompetencyController');

	Route::resource('quadranCompetencies', 'QuadranCompetencyController');

	Route::resource('quadranIndividuals', 'QuadranIndividualController');

	Route::resource('quadranScores', 'QuadranScoreController');

	Route::resource('categoryCompetencies', 'CategoryCompetenciesController');

	Route::resource('questionCompetencies', 'QuestionCompetencyController');

	Route::resource('groupUsers', 'GroupUserController');

	Route::resource('users', 'UserController');

	Route::resource('results', 'ResultController');
	Route::get('results-datable', 'ResultController@datatable')->name('results-datable');
	Route::get('results-pdf/{id}','ResultController@extractPDF')->name('results-pdf');
	
	Route::get('results-excel','ResultController@exportExcel')->name('results-excel');

	Route::resource('positions', 'PositionController');

	Route::resource('categoryCompetencies', 'CategoryCompetencyController');
	Route::get('categorycompetencies/datatable', 'CategoryCompetencyController@datatable')->name('categorycompetencies/datatable');

	Route::resource('personalities', 'PersonalityController');


	Route::resource('jobfitBasics', 'JobfitBasicController');

	Route::resource('categoryJobs', 'CategoryJobController');

	Route::resource('agreementScores', 'AgreementScoreController');
//});