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
    return view('welcome');
});

/*
 * Route resources CRUD pour les modeles 
 */
Route::resource('/tests/contacts', 'CRUD\ContactController');
Route::resource('/tests/enseignants', 'CRUD\EnseignantController');
Route::resource('/tests/etudiants', 'CRUD\EtudiantController');
Route::resource('/tests/stages', 'CRUD\StageController');

/* 
 * Route de test... 
 * C'est sale mais je n'ai rien trouve de plus simple ni elegant
 */
Route::get('/tests', 'TestsController@tests');
Route::post('contacts/tests', 'CRUD\ContactController@tests')->name('contacts.tests');
Route::post('enseignants/tests', 'CRUD\EnseignantController@tests')->name('enseignants.tests');
Route::post('etudiants/tests', 'CRUD\EtudiantController@tests')->name('etudiants.tests');
Route::post('stages/tests', 'CRUD\StageController@tests')->name('stages.tests');
