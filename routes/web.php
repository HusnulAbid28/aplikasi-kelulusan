<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\AnnouncementController;

Route::get('/', [StudentAuthController::class, 'showLoginForm'])->name('student.login')->middleware('guest:student');
Route::post('/login', [StudentAuthController::class, 'login'])->name('student.login.post');
Route::post('/logout', [StudentAuthController::class, 'logout'])->name('student.logout');

Route::middleware('auth:student')->group(function () {
    Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcement.index');
    Route::get('/pengumuman/pdf', [AnnouncementController::class, 'downloadPdf'])->name('announcement.pdf');
});
