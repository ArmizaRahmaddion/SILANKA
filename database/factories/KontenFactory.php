<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Konten>
 */
class KontenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kategori_koten_id' => fake()->numberBetween(1, 4),
            'title' => fake()->sentence(6, true),
            'body' => '<p>' . fake()->paragraphs(5, true) . '</p>',
            'slug' => fake()->unique()->slug(),
            'author' => fake()->name(),
            'status' => fake()->randomElement(['draft', 'published']),
        ];
    }
}
