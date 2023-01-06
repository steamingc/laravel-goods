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


/* ----- view 호출 ----- */

//인덱스 창
// '/'로 get 요청이 올 경우 goodsController의 index 함수를 실행함
// name은 이름지어주기. 나중에 route('goods.index')로 쉽게 주소 출력이 가능하다
Route::get('/', 'goods\goodsController@index')->name('goods.index'); 

//등록 창
Route::get('/register', 'goods\goodsController@goods_register');

//상품 상세 창
Route::get('/read/{idx}', 'goods\goodsController@goods_read');

//상품 수정 창
Route::get('read/modifying/{idx}', 'goods\goodsController@goods_modify');

//상품 삭제 창
Route::get('select', 'goods\goodsController@goods_select');

//정렬 - 상품명1
Route::get('goodsnm1', 'goods\goodsController@goods_name1'); 

//정렬 - 상품명2(desc)
Route::get('goodsnm2', 'goods\goodsController@goods_name2'); 

//정렬 - 등록일1
Route::get('goodsrgt1', 'goods\goodsController@goods_rgt1'); 

//정렬 - 등록일2(desc)
Route::get('goodsrgt2', 'goods\goodsController@goods_rgt2');

//보기 - 5개
Route::get('goodsby5', 'goods\goodsController@goods_by5');

//보기 - 15개
Route::get('goodsby15', 'goods\goodsController@goods_by15');

//상품 검색
Route::get('search?name={input}','goods\goodsController@search');
// Route::post('search','goods\goodsController@search');


/* ----- db관련 ----- */
//상품등록
//store요청은 form을 통해 post로 온다
Route::post('/store', 'goods\goodsController@store')->name('goods.store');

//상품 수정
Route::post('/modify/{idx}', 'goods\goodsController@modify')->name('goods.modify');

//상품 삭제
Route::post('delete','goods\goodsController@delete');

