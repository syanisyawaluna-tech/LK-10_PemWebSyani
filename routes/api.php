<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MahasiswaApiController;

Route::name('api.')->group(function () {
    Route::apiResource('mahasiswa', MahasiswaApiController::class);
});
