<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    protected $model = Publisher::class;

    public function definition(): array
    {
        return [
            'publisher_name' => fake()->unique()->company(),
            'publication_origin' => fake()->city() . ', ' . fake()->country(),
            'publication_type' => fake()->randomElement(['Academic', 'Trade', 'University Press', 'Commercial']),
        ];
    }
}
