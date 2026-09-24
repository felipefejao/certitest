<?php

namespace Database\Factories;

use App\Models\ExamThemeSuggestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExamThemeSuggestion>
 */
class ExamThemeSuggestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'theme' => fake()->sentence(3),
            'email' => fake()->safeEmail(),
            'published' => false,
        ];
    }
}
