<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;

// Базовый тест
Route::get('/test', [TestController::class, 'index']);

// Поиск с query параметрами (должен быть перед {id})
Route::get('/users/search', [TestController::class, 'search']);

// CRUD для пользователей (тестовые роуты)
Route::get('/users/{id}', [TestController::class, 'show']);
Route::post('/users', [TestController::class, 'store']);
Route::put('/users/{id}', [TestController::class, 'update']);
Route::delete('/users/{id}', [TestController::class, 'destroy']);
