<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Route yang dapat diakses oleh semua pengguna terdaftar (admin & user)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/my-borrowings', [BorrowingController::class, 'myBorrowings'])->name('user.my-borrowings');
    Route::get('/check-availability', [ItemController::class, 'checkAvailability'])->name('user.check-availability');
    

    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route khusus untuk Admin. Semua rute di sini hanya bisa diakses oleh Admin.
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    
    //download excel brok
    Route::get('/borrowings/export/excel', [BorrowingController::class, 'exportExcel'])->name('borrowings.export.excel');

    // Fitur Admin - Mendaftarkan Benda
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::get('/items/{item}/qrcode/download', [ItemController::class, 'downloadQrCode'])->name('items.download-qrcode');
    
    // Riwayat Peminjaman & Kelola
    Route::get('/borrowings/history', [BorrowingController::class, 'history'])->name('borrowings.history');
    Route::get('/borrowings/history/download', [BorrowingController::class, 'downloadHistory'])->name('borrowings.download-history');
    Route::delete('/borrowings/{borrowing}', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');
    // Fitur Admin - Mengelola Inventaris
    Route::get('/items', [ItemController::class, 'index'])->name('admin.items.index');

    // Fitur Admin - Peminjaman (Melalui QR atau Manual)
    Route::get('/scan', function () {
        return view('scanner');
    })->name('scanner');
    Route::get('/borrow', [ItemController::class, 'borrowForm'])->name('items.show-borrow-form');
    Route::post('/borrow', [ItemController::class, 'borrow'])->name('items.borrow');
    Route::get('/borrow/success', [ItemController::class, 'borrowSuccess'])->name('items.borrow-success');

    // Fitur Admin - Pengelolaan Peminjaman & Riwayat
    Route::get('/borrowings/active', [BorrowingController::class, 'activeBorrowings'])->name('borrowings.active');
    Route::put('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnItem'])->name('borrowings.return');
    Route::get('/borrowings/history', [BorrowingController::class, 'history'])->name('borrowings.history');

    // Fitur Admin - Mengelola Pengguna
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    //hapus berkas terdaftar 
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    
});

require __DIR__.'/auth.php';