<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// Route legacy dipertahankan agar URL lama seperti /dapur.php tetap bekerja.
Route::match(['GET', 'POST'], '/{legacy}', [InventoryController::class, 'legacy'])
    ->where('legacy', '^(index|dapur|taman|pahlawan)(-(kirim-ke|terima-dari)-(dapur|taman|pahlawan)|-(penjualan|rusak|record))?\.php$')
    ->name('legacy');

// Alias clean URL, bukan pengganti route lama.
Route::match(['GET', 'POST'], '/{branch}', [InventoryController::class, 'dashboard'])
    ->whereIn('branch', ['dapur', 'taman', 'pahlawan']);
Route::match(['GET', 'POST'], '/{source}/kirim-ke/{target}', [InventoryController::class, 'transfer'])
    ->whereIn('source', ['dapur', 'taman', 'pahlawan'])
    ->whereIn('target', ['dapur', 'taman', 'pahlawan']);
Route::match(['GET', 'POST'], '/{branch}/terima-dari/{source}', [InventoryController::class, 'receive'])
    ->whereIn('branch', ['dapur', 'taman', 'pahlawan'])
    ->whereIn('source', ['dapur', 'taman', 'pahlawan']);
Route::match(['GET', 'POST'], '/{branch}/{type}', [InventoryController::class, 'movement'])
    ->whereIn('branch', ['dapur', 'taman', 'pahlawan'])
    ->whereIn('type', ['penjualan', 'rusak']);
Route::get('/{branch}/record', [InventoryController::class, 'record'])
    ->whereIn('branch', ['dapur', 'taman', 'pahlawan']);
