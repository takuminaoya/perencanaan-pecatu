<?php

use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/print/rkk/{id}', [PrintController::class, 'printRKK'])->name('print.rkk');
Route::get('/download/rkk/{id}', [PrintController::class, 'downloadRKK'])->name('download.rkk');