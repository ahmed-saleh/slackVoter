<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use \App\Http\Controllers\ItemController;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resources([
        'event' => EventController::class,
        'item' => ItemController::class
    ]);
});

Route::middleware('auth:sanctum')->put('event/{id}/vote', [EventController::class, 'vote']);
