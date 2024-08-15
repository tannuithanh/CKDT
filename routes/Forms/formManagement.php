<?php
use App\Http\Controllers\FormManagement;
use Illuminate\Support\Facades\Route;

Route::get('/Forms-Management', [FormManagement::class, 'formsManagement'])->name('formsManagement');

Route::Post('/delete-GXP', [FormManagement::class, 'deleteLeaveForm'])->name('deleteLeaveForm');

Route::Post('/get-UsersAll-Input', [FormManagement::class, 'getUsersAllInput'])->name('getUsersAllInput');

Route::Post('/search-LeaveForm-Data', [FormManagement::class, 'searchLeaveFormData'])->name('searchLeaveFormData');

//GET PYC
Route::Post('/get-PYC', [FormManagement::class, 'getPYC'])->name('getPYC');

Route::Post('/search-JobRequestForm-Data', [FormManagement::class, 'searchJRFData'])->name('searchJRFData');
