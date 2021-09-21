<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use \App\Http\Controllers\ItemController;

Route::resources([
    'event'=> EventController::class,
    'item' =>  ItemController::class
]);


Route::put('event/{id}/vote', [EventController::class, 'vote']);
