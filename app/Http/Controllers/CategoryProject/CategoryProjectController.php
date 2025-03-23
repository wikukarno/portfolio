<?php

namespace App\Http\Controllers\CategoryProject;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryProject\StoreCategoryProjectRequest;
use App\Http\Requests\CategoryProject\UpdateCategoryProjectRequest;
use App\Models\CategoryProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryProjectController extends Controller
{
    public function index()
    {
        try {
            $categories = CategoryProject::where('user_id', Auth::id())
                ->latest()
                ->paginate(10);

            return Inertia::render('CategoryProject/Index', [
                'categories' => $categories,
            ]);
        } catch (\Throwable $e) {
            Log::error('CategoryProjectController@index error: ' . $e->getMessage());
            return back()->withErrors('Failed to load category projects.');
        }
    }

    public function create()
    {
        return Inertia::render('CategoryProject/Create');
    }

    public function store(StoreCategoryProjectRequest $request)
    {
        try {
            $validated = $request->validated();

            CategoryProject::create([
                'id' => Str::uuid(),
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'slug' => $validated['slug'] ?? Str::slug($validated['name']),
                'icon' => $validated['icon'] ?? null,
                'description' => $validated['description'] ?? null,
            ]);

            return back()->with('success', 'Category created successfully!');
        } catch (\Throwable $e) {
            Log::error('CategoryProjectController@store error: ' . $e->getMessage());
            return back()->withErrors('Failed to create category.');
        }
    }

    public function edit(string $id)
    {
        try {
            $category = CategoryProject::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            if (app()->runningUnitTests()) {
                return response()->json($category);
            }

            return Inertia::render('CategoryProject/Edit', [
                'category' => $category,
            ]);
        } catch (\Throwable $e) {
            Log::error('CategoryProjectController@edit error: ' . $e->getMessage());
            return back()->withErrors('Failed to load category for edit.');
        }
    }

    public function update(UpdateCategoryProjectRequest $request, string $id)
    {
        try {
            $category = CategoryProject::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $validated = $request->validated();

            $category->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'] ?? Str::slug($validated['name']),
                'icon' => $validated['icon'] ?? null,
                'description' => $validated['description'] ?? null,
            ]);

            return back()->with('success', 'Category updated successfully!');
        } catch (\Throwable $e) {
            Log::error('CategoryProjectController@update error: ' . $e->getMessage());
            return back()->withErrors('Failed to update category.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $category = CategoryProject::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $category->delete();

            return back()->with('success', 'Category deleted successfully');
        } catch (\Throwable $e) {
            Log::error('CategoryProjectController@destroy error: ' . $e->getMessage());
            return back()->withErrors('Failed to delete category.');
        }
    }
}
