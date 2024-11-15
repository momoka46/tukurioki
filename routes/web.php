<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [RecipeController::class, 'index'])->name('index');//ホーム画面表示

Route::get('/dashboard', function () {
    return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/calendar', [EventController::class, 'show'])->name("show")->middleware('auth'); // カレンダー表示
Route::post('/calendar/create', [EventController::class, 'create'])->name("event"); // 予定の新規追加
Route::post('/calendar/get',  [EventController::class, 'get'])->name("get"); // DBに登録した予定を取得

//Route::get('/recipes', [RecipeController::class, 'index']);   
Route::get('/recipes/create', [RecipeController::class, 'create'])->name('create')->middleware('auth');
Route::post('/recipes', [RecipeController::class, 'store']);  //画像を含めた投稿の保存処理
Route::get('/recipes/{recipe}', [RecipeController::class, 'show']); //投稿詳細画面の表示
Route::post('/recipes/like', [LikeController::class, 'likeRecipe']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
