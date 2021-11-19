<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Seeders
        $this->call(UserTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(CommentTableSeeder::class);

        //Post Like Factory
        Post::all()->each(function ($post) {
            $faker = Factory::create();
            $liked = false;
            while (!$liked) {
                try {
                    $post->likes()->attach($faker->randomElement(
                        User::pluck('id')->toArray()));
                        $liked = true;
                } catch (QueryException $error) {
                    //User has already liked post
                }
            }
        });
        
        //Comment Like Factory
        Comment::all()->each(function ($comment) {
            $faker = Factory::create();
            $liked = false;
            while (!$liked) {
                try {
                    $comment->likes()->attach($faker->randomElement(
                        User::pluck('id')->toArray()));
                        $liked = true;
                } catch (QueryException $error) {
                    //User has already liked comment
                }
            }
        });
    }
}
