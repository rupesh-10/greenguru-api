<?php

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
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

Route::post('login', [AdminController::class, 'login'])->name('login');
Route::view('login', 'login');
Route::get('logout', function () {
    Auth::guard('admin')->logout();
    return redirect('login');
})->name('logout');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'dashboard']);
    Route::view('create-shop', 'shops');
    Route::view('create-recommendation', 'recommendations');
    Route::post('create-shop', [AdminController::class, 'createShop'])->name('create-shop');
    Route::post('create-recommendations', [AdminController::class, 'createRecommendation'])->name('create-recommendation');
    Route::delete('delete-shop/{shop}', [AdminController::class, 'deleteShop'])->name('delete-shop');
    Route::delete('delete-recommendation/{recommendation}', [AdminController::class, 'deleteRecommendation'])->name('delete-recommendation');
});
