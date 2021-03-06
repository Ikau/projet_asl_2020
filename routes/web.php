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
 |
 | On notera ici que l'on a demande a Laravel de ne pas utiliser la route 'register'
 | Dans notre maquette du site, les utilisateurs sont ajoutes par l'administrateur
 |--------------------------------------------------------------------------
 */
Auth::routes(['register' => false]);


/*
 |--------------------------------------------------------------------------
 | Routes Temporaires des controllers a modifier pour la mise en prod
 |--------------------------------------------------------------------------
 */
Route::get('/home', 'HomeController@index')->name('home');



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

        Route::post('fiches/rapport', 'Fiches\FicheRapportController@tests')->name('fiches.rapport.tests');
    });
});


/*
 |--------------------------------------------------------------------------
 |                        Routes partie 'Enseignant'
 |--------------------------------------------------------------------------
 */
Route::prefix('enseignant')->group(function() {
    Route::get('accueil/', 'Enseignant\ReferentController@index')->name('referents.index');
    Route::get('affectations/', 'Enseignant\ReferentController@affectations')->name('referents.affectations');
});

/*
 |--------------------------------------------------------------------------
 |                        Routes partie 'Responsable'
 |--------------------------------------------------------------------------
 */
Route::prefix('responsable')->group(function() {
    Route::get('affectations/', 'Enseignant\ResponsableController@getIndexAffectation')->name('responsables.affectations.index');
    Route::get('affectations/form', 'Enseignant\ResponsableController@getCreateAffectation')->name('responsables.affectations.create');

    Route::post('affectations/{idStage}/valider', 'Enseignant\ResponsableController@postValiderAffectation')->name('responsables.affectations.valider');
});


/*
 |--------------------------------------------------------------------------
 |                        Routes partie 'Scolarite'
 |--------------------------------------------------------------------------
 */
Route::prefix('scolarite')->group(function() {
    Route::get('accueil/', 'Scolarite\ScolariteController@index')->name('scolarite.index');
    Route::get('affectations/', 'Scolarite\ScolariteController@affectations')->name('scolarite.affectations');
});

/*
 |--------------------------------------------------------------------------
 |                        Routes partie 'Fiche'
 |--------------------------------------------------------------------------
 */
Route::prefix('fiches')->group(function() {
    // Entreprise

    // Rapport
    Route::get('rapport/{id}', 'Fiches\FicheRapportController@show')->name('fiches.rapport.show');
    Route::get('rapport/{id}/edit', 'Fiches\FicheRapportController@edit')->name('fiches.rapport.edit');
    Route::patch('rapport/{id}', 'Fiches\FicheRapportController@update')->name('fiches.rapport.update');

    // Soutenance

    // Synthese
});
