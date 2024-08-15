<?php
use App\Http\Controllers\Setting;
use Illuminate\Support\Facades\Route;

Route::get('/profile', [Setting::class, 'profile'])->name('profile')->middleware('auth');
Route::post('/profile/upload-avatar', [Setting::class, 'uploadAvatar'])->name('profile.uploadAvatar');
Route::post('/profile/upload-signature', [Setting::class, 'uploadSignature'])->name('uploadSignature');

Route::get('/Setting-System', [Setting::class, 'settingSystem'])->name('settingSystem')->middleware('auth');
Route::get('/Get-User-By-Id/{id}', [Setting::class, 'getUserById'])->name('getUserById')->middleware('auth');
Route::Post('/Edit-User-By-Id', [Setting::class, 'editUserById'])->name('editUserById')->middleware('auth');
Route::Post('/delete-User-By-Id', [Setting::class, 'deleteUserById'])->name('deleteUserById')->middleware('auth');
Route::Post('/Edit-Division', [Setting::class, 'editDivision'])->name('editDivision')->middleware('auth');
Route::prefix('changeSettingSystem')->middleware('auth')->group(function () {
    Route::post('/filterUsers', [Setting::class, 'filterUsers'])->name('filterUsers');
    Route::post('/get-Data-Users', [Setting::class, 'getDataUsers'])->name('getDataUsers');
});

