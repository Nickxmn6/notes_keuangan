<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FaceAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/face-login', [FaceAuthController::class, 'faceLogin'])->name('face.login');
Route::post('/check-face-data', [FaceAuthController::class, 'checkFaceData'])->name('face.check');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Face Auth Routes
    Route::post('/face-register', [FaceAuthController::class, 'registerFace'])->name('face.register');
    Route::delete('/face-delete', [FaceAuthController::class, 'deleteFace'])->name('face.delete');

    // Notes Routes (Monthly Checklist)
    Route::resource('notes', NoteController::class);

    // Transactions Routes (Finance)
    Route::resource('transactions', TransactionController::class);
});

require __DIR__.'/auth.php';
