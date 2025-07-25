<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\KompetensiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\LearningController as AdminLearningController;
use App\Http\Controllers\User\LearningController as UserLearningController;
use App\Http\Controllers\Admin\CompetencyController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\User\ProfileController;

// Halaman utama
Route::get('/', function () {
    return view('dashboard');
})->name('home');

// Dashboard User
Route::middleware(['auth', 'role:user', 'force.skill'])->group(function () {
    Route::get('/users/dashboard', [UserController::class, 'userDashboard'])->name('dashboard.users');

    // Profile routes
    Route::get('/users/profile', [\App\Http\Controllers\User\ProfileController::class, 'index'])->name('users.profile.index');
    Route::get('/users/profile/edit', [\App\Http\Controllers\User\ProfileController::class, 'edit'])->name('users.profile.edit');
    Route::post('/users/profile/update', [\App\Http\Controllers\User\ProfileController::class, 'update'])->name('users.profile.update');

    // Learning Path & Uji Kompetensi untuk user
    Route::get('/learning-path', [UserLearningController::class, 'index'])->name('users.learning.index');
    Route::get('/learning-path/{id}', [UserLearningController::class, 'show'])->name('users.learning.show');
    Route::get('/uji-kompetensi', [\App\Http\Controllers\User\KompetensiController::class, 'index'])->name('users.kompetensi.index');
    Route::get('/uji-kompetensi/{id}', [\App\Http\Controllers\User\KompetensiController::class, 'show'])->name('users.kompetensi.show');
    Route::get('/uji-kompetensi/{id}/mulai', [\App\Http\Controllers\User\KompetensiController::class, 'exam'])->name('users.kompetensi.exam');
    Route::post('/uji-kompetensi/{id}/mulai', [\App\Http\Controllers\User\KompetensiController::class, 'submitExam'])->name('users.kompetensi.exam.submit');
});

// Skill selection routes (no force.skill middleware)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/users/skills/choose', [\App\Http\Controllers\User\SkillsController::class, 'choose'])->name('users.skills.choose');
    Route::post('/users/skills/save', [\App\Http\Controllers\User\SkillsController::class, 'save'])->name('users.skills.save');
});

// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard.admin');
    Route::get('/admin/learning', [AdminLearningController::class, 'index'])->name('admin.learning.index');
    Route::post('/admin/learning', [AdminLearningController::class, 'store'])->name('admin.learning.store');
    Route::get('/admin/learning/{id}', [AdminLearningController::class, 'show'])->name('admin.learning.show');
    Route::get('/admin/learning/{id}/edit', [AdminLearningController::class, 'edit'])->name('admin.learning.edit');
    Route::put('/admin/learning/{id}', [AdminLearningController::class, 'update'])->name('admin.learning.update');
    Route::delete('/admin/learning/{id}', [AdminLearningController::class, 'destroy'])->name('admin.learning.destroy');

    // Manajemen Pengguna
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('{user}', [UserController::class, 'show'])->name('show');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('{user}', [UserController::class, 'update'])->name('update'); 
        Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Bidang Keahlian (Skills)
    Route::get('/admin/bidang', [\App\Http\Controllers\Admin\BidangController::class, 'index'])->name('admin.bidang.index');
    Route::post('/admin/bidang', [\App\Http\Controllers\Admin\BidangController::class, 'store'])->name('admin.bidang.store');
    Route::delete('/admin/bidang/{id}', [\App\Http\Controllers\Admin\BidangController::class, 'destroy'])->name('admin.bidang.destroy');

    // Learning Path & Uji Kompetensi khusus admin
    Route::get('/admin/kompetensi', [CompetencyController::class, 'index'])->name('admin.kompetensi.index');
    Route::post('/admin/kompetensi', [CompetencyController::class, 'store'])->name('admin.kompetensi.store');
    Route::get('/admin/kompetensi/{id}/edit', [CompetencyController::class, 'edit'])->name('admin.kompetensi.edit');
    Route::put('/admin/kompetensi/{id}', [CompetencyController::class, 'update'])->name('admin.kompetensi.update');
    Route::patch('/admin/kompetensi/{id}/toggle', [CompetencyController::class, 'toggle'])->name('admin.kompetensi.toggle');
    Route::delete('/admin/kompetensi/{id}', [CompetencyController::class, 'destroy'])->name('admin.kompetensi.destroy');

    // Soal Uji Kompetensi (nested resource)
    Route::prefix('admin/kompetensi/{competency}/soal')->name('admin.competency.soal.')->group(function () {
        Route::get('/', [SoalController::class, 'index'])->name('index');
        Route::post('/', [SoalController::class, 'store'])->name('store');
        Route::get('{soal}/edit', [SoalController::class, 'edit'])->name('edit');
        Route::put('{soal}', [SoalController::class, 'update'])->name('update');
        Route::delete('{soal}', [SoalController::class, 'destroy'])->name('destroy');
    });
    // Alias agar route lama tetap bisa dipakai
    Route::prefix('admin/kompetensi/{competency}/soal')->name('admin.kompetensi.soal.')->group(function () {
        Route::get('/', [SoalController::class, 'index'])->name('index');
        Route::post('/', [SoalController::class, 'store'])->name('store');
        Route::get('{soal}/edit', [SoalController::class, 'edit'])->name('edit');
        Route::put('{soal}', [SoalController::class, 'update'])->name('update');
        Route::delete('{soal}', [SoalController::class, 'destroy'])->name('destroy');
    });
});

// Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
