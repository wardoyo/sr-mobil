<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\CarController;

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
    return view('auth.login');
});

Auth::routes();

Route::match(["GET", "POST"], "/register", function(){
return redirect("/login");
})->name("register");

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route User

Route::resource('users', UserController::class);

//Route Category

Route::get('categories/trash',[CategoryController::class, 'trash'])->name('categories.trash');

Route::get('categories/{id}/restore',[CategoryController::class, 'restore'])->name('categories.restore');

Route::delete('/categories/{id}/delete-permanent',[CategoryController::class, 'deletePermanent'])->name('categories.delete-permanent');

Route::resource('categories', CategoryController::class);

//Route Merk

Route::get('merks/trash', [MerkController::class, 'trash'])->name('merks.trash');

Route::get('merks/{id}/restore', [MerkController::class, 'restore'])->name('merks.restore');

Route::delete('merks/{id}/delete-permanent', [MerkController::class, 'deletePermanent'])->name('merks.delete-permanent');

Route::resource('merks', MerkController::class);

//Route Car

Route::get('cars/trash', [CarController::class, 'trash'])->name('cars.trash');

Route::get('cars/{id}/restore', [CarController::class, 'restore'])->name('cars.restore');

Route::delete('cars/{id}/delete-permanent', [CarController::class, 'deletePermanent'])->name('cars.delete-permanent');

Route::resource('cars', CarController::class);

