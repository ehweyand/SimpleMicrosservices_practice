<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::middleware('auth:sanctum')->prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::get('/{id}', [EventController::class, 'show']);
    Route::post('/', [EventController::class, 'store']);
    Route::put('/{id}', [EventController::class, 'update']);
    Route::delete('/{id}', [EventController::class, 'destroy']);

    Route::post('/{eventId}/signup', [EventController::class, 'signUpInEvent']);
    Route::post('/{eventId}/unsign', [EventController::class, 'removeSubscription']);
    Route::post('/markAttendance', [EventController::class, 'markAttendance']);
    Route::get('/subscriptions/{id}', [EventController::class, 'subscriptionsByUser']);

});

