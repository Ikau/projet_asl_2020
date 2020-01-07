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
 |--------------------------------------------------------------------------
 | Routes generees par Laravel pour la gestion de l'authentification
 | Voir :
 | vendor/laravel/framework/src/Illuminate/Routing/Router->auth()
 |--------------------------------------------------------------------------
 */

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/*
 |--------------------------------------------------------------------------
 | Routes Temporaires des controllers a modifier pour la mise en prod
 |--------------------------------------------------------------------------
 */

/*
 * Route resources CRUD pour les modeles 
 */
Route::resource('contacts', 'CRUD\ContactController');
Route::resource('enseignants', 'CRUD\EnseignantController');
Route::resource('entreprises', 'CRUD\EntrepriseController');
Route::resource('etudiants', 'CRUD\EtudiantController');
Route::resource('stages', 'CRUD\StageController');
Route::resource('soutenances', 'CRUD\SoutenanceController');

/* 
 * Route de test... 
 * C'est sale mais je n'ai rien trouve de plus simple ni elegant
 */
Route::get('/tests', 'TestsController@tests');
Route::post('tests/controller/contacts/', 'CRUD\ContactController@tests')->name('contacts.tests');
Route::post('tests/controller/enseignants/', 'CRUD\EnseignantController@tests')->name('enseignants.tests');
Route::post('tests/controller/entreprises/', 'CRUD\EntrepriseController@tests')->name('entreprises.tests');
Route::post('tests/controller/etudiants/', 'CRUD\EtudiantController@tests')->name('etudiants.tests');
Route::post('tests/controller/stages/', 'CRUD\StageController@tests')->name('stages.tests');
Route::post('tests/controller/soutenances/', 'CRUD\SoutenanceController@tests')->name('soutenances.tests');
