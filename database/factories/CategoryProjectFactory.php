<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoryProject>
 */
class CategoryProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(2, true);

        return [
            'id' => Str::uuid(),
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'icon' => 'tag',
            'description' => $this->faker->sentence(),
        ];
    }
}
