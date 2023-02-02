<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

Route::get('/', [UploadController::class, 'index'])->name('upload.index');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload.upload');
Route::get('/prices', [UploadController::class, 'prices'])->name('upload.prices');


