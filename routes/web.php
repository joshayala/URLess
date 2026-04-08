<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LinkController::class, 'index'])->name('links.index');
Route::post('/links', [LinkController::class, 'store'])->middleware('throttle:10,1')->name('links.store');
Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
Route::get('/{short_code}', [LinkController::class, 'redirect'])->where('short_code', '[A-Za-z0-9]{6}')->name('links.redirect');
