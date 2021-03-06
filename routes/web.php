<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function() {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['auth:sanctum', 'verified'], function() {
    Route::get('/userCourses', 'App\Http\Controllers\CourseController@userCourses')->name('userCourses');
    
    Route::get('/courses', 'App\Http\Controllers\CourseController@index')->name('courses');
    Route::get('/courses/create', 'App\Http\Controllers\CourseController@create')->name('courses.create');
    Route::post('/courses', 'App\Http\Controllers\CourseController@store')->name('courses.store');

    Route::get('/course/{id}', 'App\Http\Controllers\CourseController@show')->name('courses.show');
    
    Route::get('/course/edit/{id}', 'App\Http\Controllers\CourseController@edit')->name('courses.edit');
    Route::put('/course/edit/{id}', 'App\Http\Controllers\CourseController@update')->name('courses.update');
    Route::delete('/course/edit/{id}', 'App\Http\Controllers\CourseController@destroy')->name('courses.destroy');
    
    Route::post('/toggleProgress', 'App\Http\Controllers\CourseController@toggleProgress')->name('courses.toggle');
});
