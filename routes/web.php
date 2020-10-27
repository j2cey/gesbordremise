<?php

use Illuminate\Support\Facades\Auth;
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

Route::prefix('ldap')->group(function(){
    Route::get('/test', 'CustomLdapController@test')->name('ldaptest');
    Route::get('/sync', 'CustomLdapController@sync')->name('ldapsync');
});

// Route pour test de Master/Details avec Vuejs et VueX
Route::get('persons', 'PersonController@index');

Route::get('/product', 'ProductController@index')->name('product');
Route::get('/product/fetch', 'ProductController@fetch')->name('product.fetch');
Route::get('/product/{product_id}/edit', 'ProductController@edit')->name('product.edit');
Route::get('/product/{product_id}/destroy', 'ProductController@destroy')->name('product.destroy');

Route::get('permissions','RoleController@permissions')->middleware('auth');
Route::resource('roles','RoleController')->middleware('auth');
Route::get('hasrole/{roleid}','RoleController@hasrole')->middleware('auth');
Route::resource('users','UserController')->middleware('auth');

Route::resource('workflows','WorkflowController')->middleware('auth');
Route::get('workflows.fetch','WorkflowController@fetch')
    ->name('workflows.fetch')
    ->middleware('auth');

Route::resource('workflowsteps','WorkflowStepController')->middleware('auth');
Route::resource('workflowactions','WorkflowActionController')->middleware('auth');

Route::resource('workflowactiontypes','WorkflowActionTypeController')->middleware('auth');
Route::resource('workflowobjects','WorkflowObjectController')->middleware('auth');
Route::resource('workflowobjectfields','WorkflowObjectFieldController')->middleware('auth');

Route::resource('bordereauremises','BordereauremiseController')->middleware('auth');
Route::get('bordereauremises.fetch','BordereauremiseController@fetch')
    ->name('bordereauremises.fetch')
    ->middleware('auth');
Route::get('bordereauremisetest','BordereauremiseController@bordereauremisetest')
    ->middleware('auth');

Route::resource('workflowexecs','WorkflowExecController')->middleware('auth');
Route::resource('workflowexecactions','WorkflowExecActionController')->middleware('auth');

Route::resource('workflowexecmodelsteps', 'WorkflowExecModelStepController')->middleware('auth');
Route::get('canexecstep/{stepid}', 'WorkflowExecModelStepController@canexecstep')->middleware('auth');
Route::post('actionstoexec', 'WorkflowExecModelStepController@actionstoexec')->middleware('auth');

//Route::get('/home', 'HomeController@index')->name('home');

Route::resource('settings','SettingController');

Route::get('dashboards','DashboardController@index')
    ->name('dashboards.index')
    ->middleware('auth');
Route::get('dashboards/fetch','DashboardController@fetch')
    ->name('dashboards.fetch')
    ->middleware('auth');
Route::get('dashboards/fetchagence/{id}','DashboardController@fetchagence')
    ->name('dashboards.fetchagence')
    ->middleware('auth');


Route::get('bordereauremiselocs.fetch','BordereauremiseLocController@fetch')
    ->name('bordereauremiselocs.fetch')
    ->middleware('auth');
