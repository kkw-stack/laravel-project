<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notice>
 */
class NoticeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_notice' => fake()->boolean(10),
            'manager_id' => 1,
            'title' => fake()->sentence(10),
            'content' => fake()->sentence(100),
            'status' => fake()->boolean(10),
            'published_at' => now(),
        ];
    }
}
