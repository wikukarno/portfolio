<?php

use App\Models\User;
use App\Models\CategoryProject;
use function Pest\Laravel\{
    actingAs,
    getJson,
    postJson,
    putJson,
    deleteJson
};

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list all category projects for authenticated user', function () {
    CategoryProject::factory()->count(3)->create([
        'user_id' => $this->user->id,
    ]);

    $response = getJson(route('admin.category-projects.index'));

    $response->assertOk()
        ->assertJsonCount(3);
});

it('can create a new category project', function () {
    $response = postJson(route('admin.category-projects.store'), [
        'name' => 'Web Development',
        'slug' => 'web-development',
        'icon' => 'code',
        'description' => 'Web dev related stuff',
    ]);

    $response->assertOk()
        ->assertJsonFragment([
            'name' => 'Web Development',
            'slug' => 'web-development',
        ]);

    expect(CategoryProject::where('slug', 'web-development')->exists())->toBeTrue();
});

it('can show a single category project', function () {
    $category = CategoryProject::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Machine Learning',
    ]);

    $response = getJson(route('admin.category-projects.show', $category->id));

    $response->assertOk()
        ->assertJsonFragment([
            'name' => 'Machine Learning',
        ]);
});

it('can edit a category project view', function () {
    $category = CategoryProject::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $response = getJson(route('admin.category-projects.edit', $category->id));

    $response->assertOk()
        ->assertJsonFragment([
            'id' => $category->id,
        ]);
});

it('can update a category project', function () {
    $category = CategoryProject::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Old Name',
        'slug' => 'old-name',
    ]);

    $response = putJson(route('admin.category-projects.update', $category->id), [
        'name' => 'Updated Name',
        'slug' => 'updated-name',
        'icon' => 'bolt',
        'description' => 'Updated desc',
    ]);

    $response->assertOk()
        ->assertJsonFragment([
            'name' => 'Updated Name',
            'slug' => 'updated-name',
        ]);

    $category->refresh();
    expect($category->name)->toBe('Updated Name');
});

it('can delete a category project', function () {
    $category = CategoryProject::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $response = deleteJson(route('admin.category-projects.destroy', $category->id));

    $response->assertOk()
        ->assertJsonFragment([
            'message' => 'Category deleted successfully!',
        ]);

    expect(CategoryProject::withTrashed()->find($category->id)->trashed())->toBeTrue();
});
