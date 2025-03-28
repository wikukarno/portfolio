<?php

use App\Http\Controllers\CategoryProject\CategoryProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechStack\TechStackController;
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


        // Route Category Project
        Route::get('/category/project', [CategoryProjectController::class, 'index'])->name('category.project.index');
        Route::get('/category/project/create', [CategoryProjectController::class, 'create'])->name('category.project.create');
        Route::post('/category/project/store', [CategoryProjectController::class, 'store'])->name('category.project.store');
        Route::get('/category/project/{id}/edit', [CategoryProjectController::class, 'edit'])->name('category.project.edit');
        Route::put('/category/project/{id}', [CategoryProjectController::class, 'update'])->name('category.project.update');
        Route::delete('/category/project/{id}', [CategoryProjectController::class, 'destroy'])->name('category.project.destroy');
        // End Route Category Project

        // Route Tech Stack
        Route::get('/tech-stack', [TechStackController::class, 'index'])->name('tech.stack.index');
        Route::get('/tech-stack/create', [TechStackController::class, 'create'])->name('tech.stack.create');
        Route::post('/tech-stack/store', [TechStackController::class, 'store'])->name('tech.stack.store');
        Route::get('/tech-stack/{id}/edit', [TechStackController::class, 'edit'])->name('tech.stack.edit');
        Route::put('/tech-stack/{id}', [TechStackController::class, 'update'])->name('tech.stack.update');
        Route::delete('/tech-stack/{id}', [TechStackController::class, 'destroy'])->name('tech.stack.destroy');
        // End Route Tech Stack

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

require __DIR__.'/auth.php';
