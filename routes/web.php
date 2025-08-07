<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\KompetensiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Inspektur\LearningController as InspekturLearningController;
use App\Http\Controllers\User\LearningController as UserLearningController;
use App\Http\Controllers\Inspektur\CompetencyController;
use App\Http\Controllers\Inspektur\SoalController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\InspekturController;
use App\Http\Controllers\Inspektur\BidangController;
use App\Http\Controllers\Inspektur\SertifikatController as InspekturSertifikatController;
use App\Http\Controllers\User\SertifikatController as UserSertifikatController;
use App\Http\Controllers\Auth\ForgotDirectController;

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

    Route::get('/sertifikat', [App\Http\Controllers\User\SertifikatController::class, 'index'])
        ->name('user.sertifikat');

    Route::get('/sertifikat/{id}/download', [App\Http\Controllers\User\SertifikatController::class, 'download'])
        ->name('users.sertifikat.download');
});

// Skill selection routes (no force.skill middleware)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/users/skills/choose', [\App\Http\Controllers\User\SkillsController::class, 'choose'])->name('users.skills.choose');
    Route::post('/users/skills/save', [\App\Http\Controllers\User\SkillsController::class, 'save'])->name('users.skills.save');
});


// Dashboard Inspektur
Route::middleware(['auth', 'role:inspektur'])->group(function () {
    Route::get('/inspektur/dashboard', [App\Http\Controllers\InspekturController::class, 'index'])->name('dashboard.inspektur');

    // Learning Skill untuk Inspektur
    Route::get('/inspektur/learning', [App\Http\Controllers\Inspektur\LearningController::class, 'index'])->name('inspektur.learning.index');
    Route::post('/inspektur/learning', [App\Http\Controllers\Inspektur\LearningController::class, 'store'])->name('inspektur.learning.store');
    Route::get('/inspektur/learning/{id}', [App\Http\Controllers\Inspektur\LearningController::class, 'show'])->name('inspektur.learning.show');
    Route::get('/inspektur/learning/{id}/edit', [App\Http\Controllers\Inspektur\LearningController::class, 'edit'])->name('inspektur.learning.edit');
    Route::put('/inspektur/learning/{id}', [App\Http\Controllers\Inspektur\LearningController::class, 'update'])->name('inspektur.learning.update');
    Route::delete('/inspektur/learning/{id}', [App\Http\Controllers\Inspektur\LearningController::class, 'destroy'])->name('inspektur.learning.destroy');

    // Bidang Keahlian untuk Inspektur
    Route::get('/inspektur/bidang', [\App\Http\Controllers\Inspektur\BidangController::class, 'index'])->name('inspektur.bidang.index');
    Route::post('/inspektur/bidang', [\App\Http\Controllers\Inspektur\BidangController::class, 'store'])->name('inspektur.bidang.store');
    Route::delete('/inspektur/bidang/{id}', [\App\Http\Controllers\Inspektur\BidangController::class, 'destroy'])->name('inspektur.bidang.destroy');

    // Uji Kompetensi untuk Inspektur
    Route::get('/inspektur/kompetensi', [App\Http\Controllers\Inspektur\CompetencyController::class, 'index'])->name('inspektur.kompetensi.index');
    Route::post('/inspektur/kompetensi', [App\Http\Controllers\Inspektur\CompetencyController::class, 'store'])->name('inspektur.kompetensi.store');
    Route::get('/inspektur/kompetensi/{id}/edit', [App\Http\Controllers\Inspektur\CompetencyController::class, 'edit'])->name('inspektur.kompetensi.edit');
    Route::put('/inspektur/kompetensi/{id}', [App\Http\Controllers\Inspektur\CompetencyController::class, 'update'])->name('inspektur.kompetensi.update');
    Route::patch('/inspektur/kompetensi/{id}/toggle', [App\Http\Controllers\Inspektur\CompetencyController::class, 'toggle'])->name('inspektur.kompetensi.toggle');
    Route::delete('/inspektur/kompetensi/{id}', [App\Http\Controllers\Inspektur\CompetencyController::class, 'destroy'])->name('inspektur.kompetensi.destroy');

    // Sertifikat untuk Inspektur
    Route::prefix('inspektur/sertifikat')->name('inspektur.sertifikat.')->group(function () {
        Route::get('/', [App\Http\Controllers\Inspektur\SertifikatController::class, 'index'])->name('index');
        Route::get('/{user}/generate', [App\Http\Controllers\Inspektur\SertifikatController::class, 'generate'])->name('generate');
        Route::get('/{user}/download', [App\Http\Controllers\Inspektur\SertifikatController::class, 'download'])->name('download');
    });

    // Soal Uji Kompetensi (nested resource)
    Route::prefix('inspektur/kompetensi/{competency}/soal')->name('inspektur.competency.soal.')->group(function () {
        Route::get('/', [SoalController::class, 'index'])->name('index');
        Route::post('/', [SoalController::class, 'store'])->name('store');
        Route::get('{soal}/edit', [SoalController::class, 'edit'])->name('edit');
        Route::put('{soal}', [SoalController::class, 'update'])->name('update');
        Route::delete('{soal}', [SoalController::class, 'destroy'])->name('destroy');
    });
    // Alias agar route lama tetap bisa dipakai
    Route::prefix('inspektur/kompetensi/{competency}/soal')->name('inspektur.kompetensi.soal.')->group(function () {
        Route::get('/', [SoalController::class, 'index'])->name('index');
        Route::post('/', [SoalController::class, 'store'])->name('store');
        Route::get('{soal}/edit', [SoalController::class, 'edit'])->name('edit');
        Route::put('{soal}', [SoalController::class, 'update'])->name('update');
        Route::delete('{soal}', [SoalController::class, 'destroy'])->name('destroy');
    });
});

// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard.admin');

    // Manajemen Pengguna
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [AdminController::class, 'userList'])->name('index');
        Route::post('/', [AdminController::class, 'createUser'])->name('store');
        Route::get('{user}', [AdminController::class, 'showUser'])->name('show');
        Route::get('{user}/edit', [AdminController::class, 'editUser'])->name('edit');
        Route::put('{user}', [AdminController::class, 'updateUser'])->name('update'); 
        Route::delete('{user}', [AdminController::class, 'destroyUser'])->name('destroy');
    });

});

// Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/forgot-password-direct', [ForgotDirectController::class, 'showForm'])->name('password.forgot.direct');
Route::post('/forgot-password-direct', [ForgotDirectController::class, 'resetPassword'])->name('password.reset.direct');