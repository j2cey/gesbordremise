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
    if (Auth::check()) {
        return view('admin02');
    }
    return redirect('/login');
});

Route::get('/home', function () {
    if (Auth::check()) {
        return view('admin02');
    }
    return redirect('/login');
});

Auth::routes();

Route::get('/product', 'ProductController@index')->name('product');
Route::get('/product/fetch', 'ProductController@fetch')->name('product.fetch');
Route::get('/product/{product_id}/edit', 'ProductController@edit')->name('product.edit');
Route::get('/product/{product_id}/destroy', 'ProductController@destroy')->name('product.destroy');

Route::get('permissions','RoleController@permissions')->middleware('auth');
Route::resource('roles','RoleController')->middleware('auth');
Route::resource('users','UserController')->middleware('auth');
Route::resource('workflows','WorkflowController')->middleware('auth');
Route::resource('workflowsteps','WorkflowStepController')->middleware('auth');
Route::resource('workflowactions','WorkflowActionController')->middleware('auth');

Route::resource('workflowactiontypes','WorkflowActionTypeController')->middleware('auth');
Route::resource('workflowobjects','WorkflowObjectController')->middleware('auth');
Route::resource('workflowobjectfields','WorkflowObjectFieldController')->middleware('auth');

Route::resource('bordereauremises','BordereauremiseController')->middleware('auth');
Route::get('bordereauremises.fetch','BordereauremiseController@fetch')->middleware('auth');

Route::resource('workflowexecs','WorkflowExecController')->middleware('auth');
Route::resource('workflowexecactions','WorkflowExecActionController')->middleware('auth');

//Route::get('/home', 'HomeController@index')->name('home');
