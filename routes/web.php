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

Route::get('/test', 'TestController@test');

Route::resource('/tests/contacts', 'CRUD\ContactController');

/* 
 * Route de test... 
 * C'est sale mais je n'ai rien trouve de plus simple ni elegant
 */
Route::post('contacts/tests', 'CRUD\ContactController@tests')->name('contacts.tests');
