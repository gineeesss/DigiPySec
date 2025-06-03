<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear usuario admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@digipysecs.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Crear categorías
        $categories = [
            ['name' => 'Vulnerabilidades', 'slug' => 'vulnerabilidades'],
            ['name' => 'Pentesting', 'slug' => 'pentesting'],
            ['name' => 'Auditorías', 'slug' => 'auditorias'],
            ['name' => 'Noticias', 'slug' => 'noticias'],
            ['name' => 'Tutoriales', 'slug' => 'tutoriales'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }

        // 3. Crear tags
        $tags = [
            'Laravel', 'Livewire', 'PHP', 'JavaScript',
            'OWASP', 'XSS', 'SQLi', 'CSRF', 'RCE',
            'Zero-Day', 'Phishing', 'Malware', 'CVE', 'NIST'
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate([
                'name' => $tagName,
                'slug' => Str::slug($tagName)
            ]);
        }

        // 4. Crear posts
        Post::factory(20)->create([
            'user_id' => $admin->id,
            'published_at' => now(),
        ])->each(function ($post) {
            $post->tags()->attach(
                Tag::inRandomOrder()
                    ->limit(rand(2, 5))
                    ->pluck('id')
            );
        });
    }
}
