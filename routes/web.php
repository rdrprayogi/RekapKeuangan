<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AnalisisController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Auto login for testing
Route::get('/auto-login', function () {
    $user = \App\Models\User::where('email', 'admin@politeknik.ac.id')->first();
    if ($user) {
        Auth::login($user);
        session()->regenerate();
        return redirect()->route('dashboard')->with('success', 'Auto logged in as ' . $user->name);
    }
    return response('No user found', 404);
});

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Pengajuan routes
    Route::resource('pengajuan', PengajuanController::class);
    Route::get('/pengajuan-pending', [PengajuanController::class, 'pending'])->name('pengajuan.pending');
    Route::get('/pengajuan-approved', [PengajuanController::class, 'approved'])->name('pengajuan.approved');
    Route::get('/pengajuan-revision', [PengajuanController::class, 'revision'])->name('pengajuan.revision');
    
    // Approval routes
    Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index');
    Route::post('/approval/{pengajuan}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::post('/approval/{pengajuan}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    Route::post('/approval/{pengajuan}/revision', [ApprovalController::class, 'revision'])->name('approval.revision');
    Route::get('/approval/revision-history', [ApprovalController::class, 'revisionHistory'])->name('approval.revision_history');
    
    // Analisis routes
    Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis.index');
    Route::get('/analisis/weekly', [AnalisisController::class, 'weekly'])->name('analisis.weekly');
    Route::get('/analisis/yearly', [AnalisisController::class, 'yearly'])->name('analisis.yearly');
});

