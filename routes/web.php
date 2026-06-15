<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('mahasiswa.index');
    }
    return view('auth.login');
});

Route::get('/auth/login', function () {
    if (Auth::check()) {
        return redirect()->route('mahasiswa.index');
    }
    return view('auth.login');
})->name('login');

Route::get('/login-page', function () {
    if (Auth::check()) {
        return redirect()->route('mahasiswa.index');
    }
    return view('auth.login');
})->name('login-page');

Route::get('/auth/redirect', [AuthController::class, 'login'])->name('auth.redirect');
Route::get('/auth/callback', [AuthController::class, 'callback'])->name('auth.callback');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('mahasiswa', MahasiswaController::class);
    
    // Endpoint JSON untuk mengambil data user yang sedang login
    Route::get('/api/user', function () {
        return response()->json([
            'success' => true,
            'message' => 'Data user yang login berhasil diambil',
            'data' => Auth::user()
        ]);
    });
});