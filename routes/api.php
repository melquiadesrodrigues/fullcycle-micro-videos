<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GenreController;

Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
Route::resource('genres', GenreController::class)->except(['create', 'edit']);