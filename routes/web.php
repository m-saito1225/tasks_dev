<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BooksController;
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

/*-----------------------------------------*/
//views内からのパスとファイル名を記述
//拡張子は不要　bladeも記述不要(ファイル名のみ)
/*-----------------------------------------*/

//ログインページ
Route::get('/', function () {
	// return view('welcome');  初期値
	return view('auth.login');
});

//testページ こちらの書き方の方がいいかも 以下どちらか とりあえず短い方で
//Route::get('/test', 'App\Http\Controllers\TestController@index')->middleware(['auth'])->name('top');
// Route::get('/test', [TestController::class, 'index']);

//topページ
Route::get('/top'			, [TopsController::class , 'index'])->middleware(['auth'])->name('top');
Route::post('/upsertTask'	, [TopsController::class , 'upsertTask'])->middleware(['auth']);
//editページ
Route::post('/regist'		, [UsersController::class , 'regist'])->middleware(['auth'])->name('regist');
Route::get('/regist'		, [UsersController::class , 'regist'])->middleware(['auth'])->name('regist');
//読書一覧ページ
Route::post('/bookarchive'	, [BooksController::class , 'bookarchive'])->middleware(['auth'])->name('bookarchive');
Route::get('/bookarchive'	, [BooksController::class , 'bookarchive'])->middleware(['auth'])->name('bookarchive');
//読書詳細ページ
Route::post('/booksingle'	, [BooksController::class, 'booksingle'])->middleware(['auth'])->name('booksingle');
Route::get('/booksingle'	, [BooksController::class, 'booksingle'])->middleware(['auth'])->name('booksingle');
//
Route::post('/updateStatus'	, [TopsController::class , 'updateStatus'])->middleware(['auth']);
Route::post('/deleteTask'	, [TopsController::class , 'deleteTask'])->middleware(['auth']);
Route::post('/copyTask'		, [TopsController::class , 'copyTask'])->middleware(['auth']);

Route::post('/upsertBook', [BooksController::class, 'upsertBook'])->middleware(['auth']);

require __DIR__.'/auth.php';
