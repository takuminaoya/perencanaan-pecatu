<?php

use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Route;

Route::get('/print/apbg/{id}/{mode}', [PrintController::class, 'printAPBD'])->name('print.apbd');