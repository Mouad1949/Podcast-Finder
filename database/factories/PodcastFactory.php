<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Podcast>
 */
class PodcastFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->paragraph(3),
            'catégorie' => fake()->randomElement(['informatique','politice','sports']),
            'image' => fake()->imageUrl(),
            'user_id' =>User::where('role','animateur')->get('id')->random()
        ];
    }
}
