<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;

Route::middleware('auth:sanctum')->prefix('/certificates')->group(function () {
    Route::post('/generate-certificate', [CertificateController::class, 'store'])->name('generate-certificate');
});
Route::post('/certificates/authenticate', [CertificateController::class, 'authenticateCertificate']);
