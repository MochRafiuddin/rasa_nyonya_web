<?php

use App\Http\Controllers\CArea;
use App\Http\Controllers\CDashboard;
use App\Http\Controllers\CLogin;
use App\Http\Controllers\ConWilayah;
use App\Http\Controllers\CCourier;
use App\Http\Controllers\CAdmin;
use App\Http\Controllers\CCustomer;
use App\Http\Controllers\CUser;
use App\Http\Controllers\COrder;
use App\Http\Controllers\CReport;

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
Route::get('/download-apk',[CUser::class,'apk']);

Route::middleware(['auth','language'])->group(function ()
{
    ### DROPDOWN LIST MENU ###
    Route::group(['prefix' => 'master'],function ()
    {        
        Route::get('area',[CArea::class,'index'])->name('area-index');
        Route::get('wilayah',[ConWilayah::class,'index'])->name('wilayah-index');
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
        Route::get('/create',[ConWilayah::class,'create']);
        Route::post('/create-save',[ConWilayah::class,'create_save']);
        Route::get('/show/{id}',[ConWilayah::class,'show']);
        Route::post('/show-save/{id}',[ConWilayah::class,'show_save']);
        Route::get('/delete/{id}',[ConWilayah::class,'delete']);
        Route::get('/data',[ConWilayah::class,'datatable']);
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
        Route::get('/get-wilayah-by-area-filter',[CCourier::class,'get_wilayah_by_area_filter']);
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
    Route::group(['prefix' => 'report'],function ()
    {
        Route::get('/courier-performance',[CReport::class,'index'])->name('courier-performance-index');
        Route::get('/courier-fee',[CReport::class,'index_fee'])->name('courier-fee-index');
        Route::get('/detail-courier-performance/{id}/{id1}',[CReport::class,'detail_performance']);
        Route::get('/detail-courier-fee/{id}/{id1}',[CReport::class,'detail_fee']);
    });
    Route::group(['prefix' => 'courier-performance'],function ()
    {        
        Route::get('/data',[CReport::class,'datatable']);
        Route::get('/data-detail',[CReport::class,'datatable_detail_performance']);
        Route::get('/get-total-performance',[CReport::class,'get_total_performance']);
    });
    Route::group(['prefix' => 'courier-fee'],function ()
    {        
        Route::get('/data',[CReport::class,'datatable_fee']);
        Route::get('/data-detail',[CReport::class,'datatable_detail_fee']);
        Route::get('/get-total-fee',[CReport::class,'get_total_fee']);
    });
}); 