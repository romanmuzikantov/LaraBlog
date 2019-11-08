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

// Route::get('/', function () {
//     return view('home');
// });

// Route::get('/contact', function () {
//     return view('contact');
// });

Route::get('/', 'HomeController@home')->name('home');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::get('/secret', 'HomeController@secret')->name('secret')->middleware('can:access-secret');
Route::resource('/post', 'PostController');
Route::resource('post.comment', 'CommentController')->only(['store']);
Route::post('/post/{post}', 'PostController@restore')->name('post.restore');
Route::get('/post/tag/{tag}', 'PostTagController@index')->name('post.tag.index');

Auth::routes();