<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/ping', [\App\Http\Controllers\Api\Dashboard::class, 'index']);