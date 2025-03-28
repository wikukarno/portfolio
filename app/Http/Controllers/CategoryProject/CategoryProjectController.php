<?php

namespace App\Http\Controllers\CategoryProject;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryProject\StoreCategoryProjectRequest;
use App\Http\Requests\CategoryProject\UpdateCategoryProjectRequest;
use App\Models\CategoryProject;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
                'icon' => $request->file('icon')->store('assets/category_icons', 'public'),
                'description' => $validated['description'] ?? null,
            ]);

            return back()->with('success', 'Category created successfully!');
        } catch (\Throwable $e) {
            return back()->withErrors('Failed to create category.');
        }
    }

    public function edit(string $id)
    {
        try {
            $category = CategoryProject::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail()
                ->only(['id', 'name', 'icon', 'description']);

            // for unit test
            // if (app()->runningUnitTests()) {
            //     return response()->json($category);
            // }

            return Inertia::render('CategoryProject/Edit', [
                'category' => $category,
            ]);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['error' => 'Category not found.']);
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Failed to load category for edit.']);
        }
    }
    public function update(UpdateCategoryProjectRequest $request, string $id)
    {
        try {
            $category = CategoryProject::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $validated = $request->validated();

            if ($request->hasFile('icon')) {
                if ($category->icon) {
                    Storage::disk('public')->delete($category->icon);
                }

                $validated['icon'] = $request->file('icon')->store('assets/category_icons', 'public');
            } else {
                unset($validated['icon']);
            }

            $category->update($validated);

            return back()->with('success', 'Category updated successfully!');
        } catch (\Throwable $e) {
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
            return back()->withErrors('Failed to delete category.');
        }
    }
}
