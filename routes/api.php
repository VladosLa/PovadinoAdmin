<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Группа веб-адресов для новостей
Route::group(['prefix' => 'news'], function () {
    // Маршруты для получения всех новостей и создания новости
    Route::get('/', [NewsController::class, 'getAllNews']);
    Route::post('/', [NewsController::class, 'store']);

    // Маршруты для конкретной новости (редактирование, удаление)
    Route::group(['prefix' => '{id}'], function () {
        Route::put('/', [NewsController::class, 'update']);
        Route::delete('/', [NewsController::class, 'destroy']);
    });
});
