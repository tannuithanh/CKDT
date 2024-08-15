<?php

use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/Dashboard', [Dashboard::class, 'dashboard'])->name('dashboard')->middleware('auth');
