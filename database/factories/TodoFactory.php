<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'category_id' => Category::factory(), // Menambahkan category_id
            'title' => $this->faker->sentence(),
            'is_complete' => rand(0, 1)
        ];
    }
}
