<?php

use App\Http\Controllers\Api\CategoryController;

Route::resource('categories', CategoryController::class)->except(['create', 'edit']);