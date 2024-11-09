<?php

use Illuminate\Http\Request;

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::get('/companies', [CompanyController::class, 'index']);
Route::get('/companies-create', [CompanyController::class, 'index']);
