<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Article::factory()->create([
                'title' => 'Article ' . $i,
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam euismod, nisl eget aliquam ultricies, nunc nunc aliquet nunc, ege',
                'slug' => 'article-' . $i,
                'media_id' => $i,
                'category_id' => 1,
                'user_id' => 1,
            ]);
        }
    }
}
