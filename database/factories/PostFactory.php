<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->realText(2000),
            'excerpt' => $this->faker->paragraph(3),
            'featured_image' => null, // O usa 'posts/'.$this->faker->image('storage/app/public/posts', 800, 600, null, false)
            'published_at' => now(),
            'is_featured' => $this->faker->boolean(20),
            'category_id' => Category::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
