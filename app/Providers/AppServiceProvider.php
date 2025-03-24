<?php

namespace App\Providers;

use App\Models\CategoryProject;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectTechStack;
use App\Models\TechStack;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        
        Project::creating(fn($model) => $model->id = Str::uuid());
        TechStack::creating(fn($model) => $model->id = Str::uuid());
        CategoryProject::creating(fn($model) => $model->id = Str::uuid());
        ProjectImage::creating(fn($model) => $model->id = Str::uuid());
        ProjectTechStack::creating(fn($model) => $model->id = Str::uuid());

        Inertia::share('flash', function () {
            return [
                'success' => session('success'),
                'error' => session('error'),
            ];
        });
    }
}
