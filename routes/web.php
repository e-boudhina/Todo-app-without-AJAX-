<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

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

Auth::routes();
//Route::get('/new', [App\Http\Controllers\PagesController::class,'new']);
Route::get('/new', 'PagesController@index');
Route::post('/new/{id}/{name}/{specialty}', 'PagesController@create')->name('testing');

Route::get('/todos', 'TodosController@index');
Route::post('/todos/add', 'TodosController@create')->name('addTodo');
/*
 Remember you can use post or get also to delete and item for example. You may for example use a loaded form as a payload containing several parameters and the post request as the vessel that carries your request ,
 so instead of sending several parameters through the url then extracting them using specific commands you can simply use that post request to serve your interests better.
A get request is not recommended
*/

Route::put('/todos/{todo}', 'TodosController@update')->name('updateTodo');
Route::put('/todos/{todo}/statusUpdate', 'TodosController@updateStatus')->name('updateTodoStatus');


Route::delete('/todos/{todo}', 'TodosController@destroy')->name('deleteTodo');





Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//method 1 to go to route ( old way )

