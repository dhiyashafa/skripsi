<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\c_alternatif;
use App\Http\Controllers\c_bobot;
use App\Http\Controllers\c_kriteria;
use App\Http\Controllers\c_nilai_smart;
use App\Http\Controllers\c_ranking;
use App\Http\Controllers\c_user;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['PreventBackHistory'])->group(function () {
    Auth::routes();
});

Route::view('/test', 'test');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin', 'PreventBackHistory']], function(){
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    

    Route::resource('kelolaUser', c_user::class,[
        'names' => [
            'index' => 'admin.user.index',
            'store' => 'admin.user.store',
            'update' => 'admin.user.update',
            'destroy' => 'admin.user.delete'
        ]
    ]);
});

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'isUser','PreventBackHistory']], function(){
    Route::get('dashboard', [UserController::class, 'index'])->name('user.dashboard');
    
    Route::resource('kriteria', c_kriteria::class,[
        'names' => [
            'index' => 'user.kriteria.index',
            'store' => 'user.kriteria.store',
            'update' => 'user.kriteria.update',
            'destroy' => 'user.kriteria.delete'
        ]
    ]);
    Route::resource('bobot', c_bobot::class,[
        'names' => [
          'index' => 'user.bobot.index',
            'store' => 'user.bobot.store',
            'update' => 'user.bobot.update',
            'destroy' => 'user.bobot.delete'
        ]
    ]);
    Route::get('bobothitung', [c_bobot::class, 'bobot'])->name('user.bobothitung');

    Route::resource('alternatif', c_alternatif::class,[
        'names' => [
            'index' => 'user.alternatif.index',
            'store' => 'user.alternatif.store',
            'update' => 'user.alternatif.update',
            'destroy' => 'user.alternatif.delete'
        ]
    ]);


    Route::resource('smart', c_nilai_smart::class, [
        'names' => [
            'index' => 'user.smart.index',
            'store' => 'user.smart.store',
            'update' => 'user.smart.update',
            'utility' => 'user.smart.utility',
            'akhir' =>  'user.smart.akhir'
        ]
    ]);
    Route::post('databaru', [c_nilai_smart::class, 'databaru'])->name('user.smart.databaru');

    Route::get('utility', [c_nilai_smart::class, 'utility'])->name('user.smart.utility');
    Route::get('akhir', [c_nilai_smart::class, 'akhir'])->name('user.smart.akhir');
    Route::get('create', [c_nilai_smart::class, 'create'])->name('user.rank.create');
    Route::get('rank', [c_nilai_smart::class, 'rank'])->name('user.rank.store');

});
