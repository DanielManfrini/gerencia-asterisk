<?php

use App\Http\Controllers\Adm\AsteriskController;
use App\Http\Controllers\Filas\FilasController;
use App\Http\Controllers\Mensageiro\RabbitMQController;
use App\Http\Controllers\Ramais\ContextController;
use App\Http\Controllers\Ramais\RamaisController;
use App\Http\Controllers\Uras\UrasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'adm'], function () {

  route::any('/pjsipreload', [AsteriskController::class, 'pjsipReload']);
});

Route::group(['prefix' => 'ramais'], function () {

  Route::get('/get', [RamaisController::class, 'get']);
  Route::post('/create', [RamaisController::class, 'create']);
  Route::put('/edit', [RamaisController::class, 'edit']);
  Route::delete('/delete', [RamaisController::class, 'delete']);

  Route::group(['prefix' => 'context'], function () {
    Route::get('/get', [ContextController::class, 'get']);
    Route::post('/create', [ContextController::class, 'create']);
    Route::put('/edit', [ContextController::class, 'edit']);
    Route::delete('/delete', [ContextController::class, 'delete']);
  });
});

Route::group(['prefix' => 'filas'], function () {
  Route::get('/get', [FilasController::class, 'get']);
  Route::post('/create', [FilasController::class, 'create']);
  Route::put('/edit', [FilasController::class, 'edit']);
  Route::delete('/delete', [FilasController::class, 'delete']);
});

Route::group(['prefix' => 'uras'], function () {
  Route::get('/get', [UrasController::class, 'get']);
  Route::post('/create', [UrasController::class, 'create']);
  Route::put('/edit', [UrasController::class, 'edit']);
  Route::delete('/delete', [UrasController::class, 'delete']);
});

Route::group(['prefix' => 'messenger'], function () {
  Route::post('/send', [RabbitMQController::class, 'send']);
});
