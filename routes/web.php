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
Auth::routes();

Route::group(['middleware' => ['web','auth','role:admin']], function () {
    Route::get('permissions', 'PermissionController@index')->name('permissions.index');
});

Route::group(['middleware' => ['web','auth','role:admin|examiner']], function () {
    Route::get('/', 'HomeController@index')->name('home');
});

Route::group(['middleware' => ['web','auth','role:examiner']], function() {
    Route::get('examiner', 'HomeController@examiner')->name('exam.examiner');
    Route::get('end', 'HomeController@end')->name('exam.end');
    Route::get('matchUser', 'HomeController@matchUser')->name('exam.matchUser');
});