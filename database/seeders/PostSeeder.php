<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
         = [
            [
                'author_id' => 1,
                'title' => 'Getting Started with Laravel',
                'slug' => 'getting-started-with-laravel',
                'content' => 'Laravel is a powerful PHP framework that makes web development enjoyable. In this post, we will explore the basics of Laravel and how to get started with your first project.',
                'featured_image' => 'https://picsum.photos/800/400?random=1',
                'status' => 'published',
                'views' => rand(10, 1000),
                'published_at' => now()->subDays(rand(1, 30)),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()
            ],
            [
                'author_id' => 1,
                'title' => '10 Tips for Better PHP Code',
                'slug' => '10-tips-for-better-php-code',
                'content' => 'Writing clean and efficient PHP code is essential for maintainable applications. Here are 10 tips that will help you write better PHP code and avoid common pitfalls.',
                'featured_image' => 'https://picsum.photos/800/400?random=2',
                'status' => 'published',
                'views' => rand(10, 1000),
                'published_at' => now()->subDays(rand(1, 30)),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()
            ],
            [
                'author_id' => 1,
                'title' => 'Understanding Database Relationships',
                'slug' => 'understanding-database-relationships',
                'content' => 'Database relationships are the backbone of any robust application. Learn about one-to-one, one-to-many, and many-to-many relationships in this comprehensive guide.',
                'featured_image' => 'https://picsum.photos/800/400?random=3',
                'status' => 'published',
                'views' => rand(10, 1000),
                'published_at' => now()->subDays(rand(1, 30)),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()
            ],
            [
                'author_id' => 1,
                'title' => 'Building RESTful APIs with Laravel',
                'slug' => 'building-restful-apis-with-laravel',
                'content' => 'APIs are essential for modern web applications. This tutorial will guide you through building a RESTful API using Laravel\'s built-in features and best practices.',
                'featured_image' => 'https://picsum.photos/800/400?random=4',
                'status' => 'published',
                'views' => rand(10, 1000),
                'published_at' => now()->subDays(rand(1, 30)),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()
            ],
            [
                'author_id' => 1,
                'title' => 'Docker for PHP Developers',
                'slug' => 'docker-for-php-developers',
                'content' => 'Docker has revolutionized the way we develop and deploy applications. Learn how to use Docker in your PHP development workflow and create consistent environments.',
                'featured_image' => 'https://picsum.photos/800/400?random=5',
                'status' => 'draft',
                'views' => rand(10, 1000),
                'published_at' => null,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()
            ],
            [
                'author_id' => 1,
                'title' => 'Mastering Eloquent ORM',
                'slug' => 'mastering-eloquent-orm',
                'content' => 'Eloquent ORM is one of Laravel\'s most powerful features. This deep dive will help you master Eloquent and write efficient database queries with ease.',
                'featured_image' => 'https://picsum.photos/800/400?random=6',
                'status' => 'published',
                'views' => rand(10, 1000),
                'published_at' => now()->subDays(rand(1, 30)),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()
            ]
        ];

        DB::table('posts')->insert();
    }
}
