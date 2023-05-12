<?php

use App\Http\Controllers\CArea;
use App\Http\Controllers\CDashboard;
use App\Http\Controllers\CLogin;
use App\Http\Controllers\CWilayah;
use App\Http\Controllers\CCourier;
use App\Http\Controllers\CAdmin;
use App\Http\Controllers\CCustomer;
use App\Http\Controllers\CUser;
use App\Http\Controllers\COrder;

use Illuminate\Support\Facades\DB;
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

Route::get('/', [CLogin::class,'index'])->middleware("guest");
Route::post('/auth', [CLogin::class,'authenticate']);
Route::get('/logout', [CLogin::class,'logout']);

Route::middleware(['auth','language'])->group(function ()
{
    ### DROPDOWN LIST MENU ###
    Route::group(['prefix' => 'master'],function ()
    {        
        Route::get('area',[CArea::class,'index'])->name('area-index');
        Route::get('wilayah',[CWilayah::class,'index'])->name('wilayah-index');
        Route::get('courier',[CCourier::class,'index'])->name('courier-index');
        Route::get('admin',[CAdmin::class,'index'])->name('admin-index');
        Route::get('customer',[CCustomer::class,'index'])->name('customer-index');
        Route::get('user',[CUser::class,'index'])->name('user-index');
    });    

    ### DASHBOARD ###
    Route::group(['prefix' => 'dashboard'],function ()
    {
        Route::get('/',[CDashboard::class,'index']);      
    });

    ### AREA ###
    Route::group(['prefix' => 'area'],function ()
    {
        Route::get('/create',[CArea::class,'create']);
        Route::post('/create-save',[CArea::class,'create_save']);
        Route::get('/show/{id}',[CArea::class,'show']);
        Route::post('/show-save/{id}',[CArea::class,'show_save']);
        Route::get('/delete/{id}',[CArea::class,'delete']);
        Route::get('/data',[CArea::class,'datatable']);
    });    
    ### Wilayah ###
    Route::group(['prefix' => 'wilayah'],function ()
    {
        Route::get('/create',[CWilayah::class,'create']);
        Route::post('/create-save',[CWilayah::class,'create_save']);
        Route::get('/show/{id}',[CWilayah::class,'show']);
        Route::post('/show-save/{id}',[CWilayah::class,'show_save']);
        Route::get('/delete/{id}',[CWilayah::class,'delete']);
        Route::get('/data',[CWilayah::class,'datatable']);
    });
    Route::group(['prefix' => 'courier'],function ()
    {
        Route::get('/create',[CCourier::class,'create']);
        Route::post('/create-save',[CCourier::class,'create_save']);
        Route::get('/show/{id}',[CCourier::class,'show']);
        Route::post('/show-save/{id}',[CCourier::class,'show_save']);
        Route::get('/delete/{id}',[CCourier::class,'delete']);
        Route::get('/data',[CCourier::class,'datatable']);

        Route::get('/get-wilayah-by-area',[CCourier::class,'get_wilayah_by_area']);
    });
    Route::group(['prefix' => 'admin'],function ()
    {
        Route::get('/create',[CAdmin::class,'create']);
        Route::post('/create-save',[CAdmin::class,'create_save']);
        Route::get('/show/{id}',[CAdmin::class,'show']);
        Route::post('/show-save/{id}',[CAdmin::class,'show_save']);
        Route::get('/delete/{id}',[CAdmin::class,'delete']);
        Route::get('/data',[CAdmin::class,'datatable']);
    });
    Route::group(['prefix' => 'customer'],function ()
    {
        Route::get('/create',[CCustomer::class,'create']);
        Route::post('/create-save',[CCustomer::class,'create_save']);
        Route::get('/show/{id}',[CCustomer::class,'show']);
        Route::post('/show-save/{id}',[CCustomer::class,'show_save']);
        Route::get('/delete/{id}',[CCustomer::class,'delete']);
        Route::get('/data',[CCustomer::class,'datatable']);
    });
    Route::group(['prefix' => 'user'],function ()
    {
        Route::get('/create',[CUser::class,'create']);
        Route::post('/create-save',[CUser::class,'create_save']);
        Route::get('/show/{id}',[CUser::class,'show']);
        Route::post('/show-save/{id}',[CUser::class,'show_save']);
        Route::get('/delete/{id}',[CUser::class,'delete']);
        Route::get('/data',[CUser::class,'datatable']);

        Route::get('/get-user-by-tipe',[CUser::class,'get_user_by_tipe']);
    });
    Route::group(['prefix' => 'order'],function ()
    {
        Route::get('/',[COrder::class,'index'])->name('order-index');
        Route::get('/data',[COrder::class,'datatable']);
        Route::get('/create',[COrder::class,'create']);
        Route::post('/create-save',[COrder::class,'create_save']);
        Route::get('/show/{id}',[COrder::class,'show']);
        Route::get('/detail/{id}',[COrder::class,'detail']);
        Route::get('/confirm/{id}',[COrder::class,'confirm']);
        Route::post('/show-save/{id}',[COrder::class,'show_save']);
        Route::post('/update-status',[COrder::class,'update_status']);
        Route::get('/delete/{id}',[COrder::class,'delete']);
        Route::post('/import',[COrder::class,'readExcel']);
    });
}); 