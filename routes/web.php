<?php

use App\Http\Controllers\FellowController;
use App\Http\Controllers\MonsterController;
use App\Http\Controllers\UserFellowController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [FellowController::class, "index"]);
// Route::get('/monsters', [MonsterController::class, "monsters"]);

Route::get('/add-fellow', [UserFellowController::class, "index"])->name('add-fellow');
Route::post('/userfellow/create', [UserFellowController::class, "create"])->name('create-fellow');
