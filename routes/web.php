<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\KompetensiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\instruktur\LearningController as instrukturLearningController;
use App\Http\Controllers\User\LearningController as UserLearningController;
use App\Http\Controllers\instruktur\CompetencyController;
use App\Http\Controllers\instruktur\SoalController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\instrukturController;
use App\Http\Controllers\instruktur\BidangController;
use App\Http\Controllers\instruktur\SertifikatController as instrukturSertifikatController;
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
    Route::get('/learning-path/{encId}', [UserLearningController::class, 'show'])->name('users.learning.show');

    // Route::get('/uji-kompetensi', [\App\Http\Controllers\User\KompetensiController::class, 'index'])->name('users.kompetensi.index');
    Route::get('/uji-kompetensi/{encId}{learning_endId?}', [\App\Http\Controllers\User\KompetensiController::class, 'show'])->name('users.kompetensi.show');
    // Route::get('/uji-kompetensi/{id}/mulai', [\App\Http\Controllers\User\KompetensiController::class, 'exam'])->name('users.kompetensi.exam');
    // Route::post('/uji-kompetensi/{id}/mulai', [\App\Http\Controllers\User\KompetensiController::class, 'submitExam'])->name('users.kompetensi.exam.submit');

    Route::get('/uji-kompetensi/{encId}/mulai', [\App\Http\Controllers\User\KompetensiController::class, 'exam'])
        ->name('users.kompetensi.exam');
    Route::post('/uji-kompetensi/{encId}/mulai', [\App\Http\Controllers\User\KompetensiController::class, 'submitExam'])
        ->name('users.kompetensi.exam.submit');


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


// Dashboard instruktur
Route::middleware(['auth', 'role:instruktur'])->group(function () {
    Route::get('/instruktur/dashboard', [App\Http\Controllers\instrukturController::class, 'index'])->name('dashboard.instruktur');

    // Learning Skill untuk instruktur
    Route::get('/instruktur/learning', [App\Http\Controllers\instruktur\LearningController::class, 'index'])->name('instruktur.learning.index');
    Route::post('/instruktur/learning', [App\Http\Controllers\instruktur\LearningController::class, 'store'])->name('instruktur.learning.store');
    Route::get('/instruktur/learning/{id}', [App\Http\Controllers\instruktur\LearningController::class, 'show'])->name('instruktur.learning.show');
    Route::get('/instruktur/learning/{id}/edit', [App\Http\Controllers\instruktur\LearningController::class, 'edit'])->name('instruktur.learning.edit');
    Route::put('/instruktur/learning/{id}', [App\Http\Controllers\instruktur\LearningController::class, 'update'])->name('instruktur.learning.update');
    Route::delete('/instruktur/learning/{id}', [App\Http\Controllers\instruktur\LearningController::class, 'destroy'])->name('instruktur.learning.destroy');

    // Bidang Keahlian untuk instruktur
    Route::get('/instruktur/bidang', [\App\Http\Controllers\instruktur\BidangController::class, 'index'])->name('instruktur.bidang.index');
    Route::post('/instruktur/bidang', [\App\Http\Controllers\instruktur\BidangController::class, 'store'])->name('instruktur.bidang.store');
    Route::delete('/instruktur/bidang/{id}', [\App\Http\Controllers\instruktur\BidangController::class, 'destroy'])->name('instruktur.bidang.destroy');

    // Uji Kompetensi untuk instruktur
    Route::get('/instruktur/kompetensi', [App\Http\Controllers\instruktur\CompetencyController::class, 'index'])->name('instruktur.kompetensi.index');
    Route::post('/instruktur/kompetensi', [App\Http\Controllers\instruktur\CompetencyController::class, 'store'])->name('instruktur.kompetensi.store');
    Route::get('/instruktur/kompetensi/{id}/edit', [App\Http\Controllers\instruktur\CompetencyController::class, 'edit'])->name('instruktur.kompetensi.edit');
    Route::put('/instruktur/kompetensi/{id}', [App\Http\Controllers\instruktur\CompetencyController::class, 'update'])->name('instruktur.kompetensi.update');
    Route::patch('/instruktur/kompetensi/{id}/toggle', [App\Http\Controllers\instruktur\CompetencyController::class, 'toggle'])->name('instruktur.kompetensi.toggle');
    Route::delete('/instruktur/kompetensi/{id}', [App\Http\Controllers\instruktur\CompetencyController::class, 'destroy'])->name('instruktur.kompetensi.destroy');

    // Sertifikat untuk instruktur
    Route::prefix('instruktur/sertifikat')->name('instruktur.sertifikat.')->group(function () {
        Route::get('/', [App\Http\Controllers\instruktur\SertifikatController::class, 'index'])->name('index');
        Route::get('/{user}/generate', [App\Http\Controllers\instruktur\SertifikatController::class, 'generate'])->name('generate');
        Route::get('/{user}/download', [App\Http\Controllers\instruktur\SertifikatController::class, 'download'])->name('download');
    });

    // Soal Uji Kompetensi (nested resource)
    Route::prefix('instruktur/kompetensi/{competency}/soal')->name('instruktur.kompetensi.soal.')->group(function () {
        Route::get('/', [SoalController::class, 'index'])->name('index');
        Route::post('/', [SoalController::class, 'store'])->name('store');
        Route::get('{soal}/edit', [SoalController::class, 'edit'])->name('edit');
        Route::put('{soal}', [SoalController::class, 'update'])->name('update');
        Route::delete('{soal}', [SoalController::class, 'destroy'])->name('destroy');
    });
    // Alias agar route lama tetap bisa dipakai
    // Route::prefix('instruktur/kompetensi/{competency}/soal')->name('instruktur.kompetensi.soal.')->group(function () {
    //     Route::get('/', [SoalController::class, 'index'])->name('index');
    //     Route::post('/', [SoalController::class, 'store'])->name('store');
    //     Route::get('{soal}/edit', [SoalController::class, 'edit'])->name('edit');
    //     Route::put('{soal}', [SoalController::class, 'update'])->name('update');
    //     Route::delete('{soal}', [SoalController::class, 'destroy'])->name('destroy');
    // });

    Route::get('/instruktur/profile', [\App\Http\Controllers\instruktur\ProfileController::class, 'index'])->name('instruktur.profile.index');
    Route::get('/instruktur/profile/edit', [\App\Http\Controllers\instruktur\ProfileController::class, 'edit'])->name('instruktur.profile.edit');
    Route::post('/instruktur/profile/update', [\App\Http\Controllers\instruktur\ProfileController::class, 'update'])->name('instruktur.profile.update');
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