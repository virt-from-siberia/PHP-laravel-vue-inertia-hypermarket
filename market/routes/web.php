<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

// Тестовый маршрут для проверки БД
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        $dbName = DB::connection()->getDatabaseName();
        return "✅ Подключение к базе данных успешно!<br>База данных: {$dbName}";
    } catch (\Exception $e) {
        return "❌ Ошибка подключения: " . $e->getMessage();
    }
});
