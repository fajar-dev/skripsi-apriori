<?php

use App\Http\Controllers\AnalystController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

Route::get('/data', [DataController::class, 'index'])->name('data');
Route::post('/data', [DataController::class, 'store'])->name('data.store');
Route::post('/data/{id}', [DataController::class, 'update'])->name('data.update');
Route::get('/data/{id}', [DataController::class, 'destroy'])->name('data.destroy');

Route::get('/analyst', [AnalystController::class, 'index'])->name('analyst');
Route::get('/analyst/apriori', [AnalystController::class, 'apriori'])->name('analyst.apriori');

