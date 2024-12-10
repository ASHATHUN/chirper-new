<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('chirps', ChirpController::class)
    // ->only(['index', 'store'])
    // บรรทัดที่ 30 เพิ่ม update เข้าไป เพื่อให้มันเปิดเส้นทาง รู้จักกับ ฟังก์ชัน Controller ที่ชื่อว่า Update ในไฟล์ ChipController เราจะค่อยๆเปิดเฉพาะตัวที่เราต้องใช้งาน
    // ->only(['index', 'store', 'update'])
    // เพิ่มคำ destroy เข้ามา เพื่อจะเปิดทางให้มันรู้จักใน Controller เพื่อสร้าง ปุ่ม delete
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
