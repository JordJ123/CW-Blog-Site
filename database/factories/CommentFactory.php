<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text(),
            'user_id' => $this->faker->randomElement(
                User::pluck('id')->toArray()),
            'post_id' => $this->faker->randomElement(
                Post::pluck('id')->toArray())
        ];
    }
}
