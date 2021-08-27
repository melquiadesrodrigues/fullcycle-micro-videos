<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class GenreFactory extends Factory
{
    protected $model = Genre::class;

    #[ArrayShape(['name' => "string"])] public function definition(): array
    {
        return [
            'name' => $this->faker->colorName,
        ];
    }
}
