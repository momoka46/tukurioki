<?php

use App\Models\Recipe;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RecipeController;

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

Route::get('/', function () {
    return view('welcome');

});
Route::get('/calendar', [EventController::class, 'show'])->name("show"); // カレンダー表示

Route::get('/recipes', [RecipeController::class, 'index']);   
Route::get('/recipes/create', [RecipeController::class, 'create']);
Route::post('/recipes', [RecipeController::class, 'store']);  //画像を含めた投稿の保存処理
Route::get('/recipes/{recipe}', [RecipeController::class, 'show']); //投稿詳細画面の表示