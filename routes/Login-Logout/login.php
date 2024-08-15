<?php
use App\Http\Controllers\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', [Login::class, 'login'])->name('login.get');
Route::post('/', [Login::class, 'loginPost'])->name('loginPost');

Route::get('/Log-Out', [Login::class, 'logOut'])->name('logOut');
