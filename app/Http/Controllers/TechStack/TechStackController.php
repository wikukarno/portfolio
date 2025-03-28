<?php

namespace App\Http\Controllers\TechStack;

use App\Http\Controllers\Controller;
use App\Http\Requests\TechStack\StoreTechStackRequest;
use App\Http\Requests\TechStack\UpdateTechStackRequest;
use App\Models\TechStack;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class TechStackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tech = TechStack::where('user_id', Auth::id())
                ->latest()
                ->paginate(10);

            return Inertia::render('TechStack/Index', [
                'tech' => $tech,
            ]);
        } catch (\Throwable $e) {
            return back()->withErrors('Failed to load data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('TechStack/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTechStackRequest $request)
    {
        try {
            $validated = $request->validated();

            TechStack::create([
                'id' => Str::uuid(),
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'slug' => $validated['slug'] ?? Str::slug($validated['name']),
                'icon' => $request->file('icon')->store('assets/tech_stack_icons', 'public'),
            ]);

            return back()->with('success', 'Data created successfully!');
        } catch (\Throwable $e) {
            return back()->withErrors('Failed to create data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $tech = TechStack::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail()
                ->only(['id', 'name', 'icon']);

            return Inertia::render('TechStack/Edit', [
                'tech' => $tech,
            ]);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['error' => 'Data not found.']);
        } catch (\Throwable $e) {
            return back()->withErrors('Failed to load data.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTechStackRequest $request, string $id)
    {
        try {
            $tech = TechStack::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $validated = $request->validated();

            if ($request->hasFile('icon')) {
                if ($tech->icon) {
                    Storage::disk('public')->delete($tech->icon);
                }

                $validated['icon'] = $request->file('icon')->store('assets/category_icons', 'public');
            } else {
                unset($validated['icon']);
            }

            $tech->update($validated);

            return back()->with('success', 'Data updated successfully!');
        } catch (\Throwable $e) {
            return back()->withErrors('Failed to update data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tech = TechStack::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $tech->delete();

            return back()->with('success', 'Data deleted successfully');
        } catch (\Throwable $e) {
            return back()->withErrors('Failed to delete data.');
        }
    }
}
