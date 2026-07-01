<?php

namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Url>
 */
class UrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'original_url' => fake()->url(),
            'short_code' => \Illuminate\Support\Str::random(6),
            'hits' => fake()->numberBetween(0, 100),
            'company_id' => \App\Models\Company::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
