<?php
use App\Http\Controllers\JobRequestFormController;
use Illuminate\Support\Facades\Route;

Route::prefix('Forms')->middleware('auth')->group(function () {
    Route::GET('/Job-Request-Form', [JobRequestFormController::class, 'jobRequestForm'])->name('jobRequestForm');
    Route::POST('/get-user-by-department', [JobRequestFormController::class, 'getUserByDepartment'])->name('getUserByDepartment');
    Route::POST('/Save-Request-Forms', [JobRequestFormController::class, 'saveRequestForm'])->name('saveRequestForm');
    Route::GET('/Check-Request-Forms/{code}', [JobRequestFormController::class, 'checkRequestForms'])->name('checkRequestForms');
});
Route::POST('/Get-Request-Forms', [JobRequestFormController::class, 'getJRFByCode'])->name('getJRFByCode');
Route::POST('/approveFormRequest', [JobRequestFormController::class, 'approveFormRequest'])->name('approveFormRequest');
