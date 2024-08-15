<?php
use App\Http\Controllers\LeaveForms;
use Illuminate\Support\Facades\Route;

Route::prefix('Forms')->middleware('auth')->group(function () {
    Route::get('/Leave-Forms', [LeaveForms::class, 'leaveForms'])->name('leaveForms');
    Route::Post('/Save-Leave-Forms', [LeaveForms::class, 'saveLeaveForms'])->name('saveLeaveForms');
    Route::get('/Get-Leave-Forms/{code}', [LeaveForms::class, 'getLeaveForms'])->name('getLeaveForms');
    Route::POST('/handle-check', [LeaveForms::class, 'handleCheck'])->name('handleCheck');
});

