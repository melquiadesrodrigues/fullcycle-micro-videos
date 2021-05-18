<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GenreController;

$exceptCreateAndEdit = ['create', 'edit'];
Route::resource('categories', CategoryController::class)->except($exceptCreateAndEdit);
Route::resource('genres', GenreController::class)->except($exceptCreateAndEdit);