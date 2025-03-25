<?php

use App\Http\Controllers\CategoryProject\CategoryProjectController;
use App\Http\Controllers\DashboardController;
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

Route::prefix('admin')
        ->name('admin.')
        ->middleware('auth', 'verified', 'admin')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


        Route::get('/category/project', [CategoryProjectController::class, 'index'])->name('category.project.index');
        Route::get('/category/project/create', [CategoryProjectController::class, 'create'])->name('category.project.create');
        Route::post('/category/project', [CategoryProjectController::class, 'store'])->name('category.project.store');
        Route::get('/category/project/{categoryProject}/edit', [CategoryProjectController::class, 'edit'])->name('category.project.edit');
        Route::put('/category/project/{categoryProject}', [CategoryProjectController::class, 'update'])->name('category.project.update');
        Route::delete('/category/project/{categoryProject}', [CategoryProjectController::class, 'destroy'])->name('category.project.destroy');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

require __DIR__.'/auth.php';
