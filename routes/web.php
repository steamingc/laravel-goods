<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\goods\goodsController;

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

/* 기존에 하던 것
Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'goods\goodsController@index');
*/

// '/'로 get 요청이 올 경우 goodsController의 index 함수를 실행함
// name은 이름지어주기. 나중에 route('goods.index')로 쉽게 주소 출력이 가능하다
Route::get('/', 'goods\goodsController@index')->name('goods.index'); 
// Route::get('/products', [goodsController::class, 'index'])->name('product.index');


// Route::get('/store', function(){
    //     return true;
    // }) -> name('store.success');
    
Route::get('/register', 'goods\goodsController@goods_register');
    
//store요청은 form을 통해 post로 온다
// Route::post('/store', 'goods\goodsController@store')->name('goods.store');
Route::post('/store', 'goods\goodsController@store')->name('goods.store');
