<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\Tag::factory(5)->create();
        \App\Models\Category::factory(10)->create();
      //\App\Models\Post::factory(100)->hasTags()->random( rand(1, 5))->create();
       \App\Models\Post::factory(100)
            ->create()
            ->each(function($post) {
                $randomTag= \App\Models\Tag::all()->random( rand(0, 5) )->pluck('id');
                $post->tags()->attach($randomTag);
            });

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
