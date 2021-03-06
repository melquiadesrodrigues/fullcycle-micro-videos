<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    #[ArrayShape(['name' => "string", 'description' => "null|string"])] public function definition(): array
    {
        return [
            'name' => $this->faker->colorName,
            'description' => rand(1, 10) % 2 == 0 ? $this->faker->sentence() : null
        ];
    }
}