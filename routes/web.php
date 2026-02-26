<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::admin.index');
Route::livewire('/roles', 'pages::admin.role.index');
Route::livewire('/roles/create', 'pages::admin.role.create');