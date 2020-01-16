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
 |--------------------------------------------------------------------------
 |  Routes zone administration
 |--------------------------------------------------------------------------
 */
Route::prefix('admin')->group(function() {
    // Home admin
    Route::get('/', 'Admin\AdminController@index')->name('admin.index');

});

/*
 * Route resources CRUD pour les modeles 
 */
Route::resource('contacts', 'CRUD\ContactController');
Route::resource('enseignants', 'CRUD\EnseignantController');
Route::resource('entreprises', 'CRUD\EntrepriseController');
Route::resource('etudiants', 'CRUD\EtudiantController');
Route::resource('privileges', 'CRUD\PrivilegeController');
Route::resource('stages', 'CRUD\StageController');
Route::resource('soutenances', 'CRUD\SoutenanceController');
Route::resource('users', 'CRUD\UserController');


/* 
 * Route de test... 
 * C'est sale mais je n'ai rien trouve de plus simple ni elegant
 */
Route::prefix('tests')->group(function() {

    Route::prefix('controllers')->group(function() {

        Route::post('contacts/', 'CRUD\ContactController@tests')->name('contacts.tests');
        Route::post('enseignants/', 'CRUD\EnseignantController@tests')->name('enseignants.tests');
        Route::post('entreprises/', 'CRUD\EntrepriseController@tests')->name('entreprises.tests');
        Route::post('etudiants/', 'CRUD\EtudiantController@tests')->name('etudiants.tests');
        Route::post('privileges/', 'CRUD\PrivilegeController@tests')->name('privileges.tests');
        Route::post('stages/', 'CRUD\StageController@tests')->name('stages.tests');
        Route::post('soutenances/', 'CRUD\SoutenanceController@tests')->name('soutenances.tests');
        Route::post('users/', 'CRUD\UserController@tests')->name('users.tests');
    });
});


/*
 |--------------------------------------------------------------------------
 |                        Routes partie 'Enseignant'
 |--------------------------------------------------------------------------
 */
Route::get('/accueil/enseignant/', 'Enseignant\ReferentController@index')->name('referents.index');
