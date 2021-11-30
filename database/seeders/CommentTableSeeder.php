<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use Faker\Factory;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jordan = new Comment;
        $jordan->text = "Oh that's unfortunate";
        $jordan->user_id = 1;
        $jordan->post_id = 3;
        $jordan->save();

        $bob = new Comment;
        $bob->text = "Hello there!";
        $bob->user_id = 2;
        $bob->post_id = 1;
        $bob->save();
        $bob->likes()->attach(1);

        $steve = new Comment;
        $steve->text = "Goodbye friend!";
        $steve->user_id = 3;
        $steve->post_id = 4;
        $steve->save();
        $steve->likes()->attach(1);
        $steve->likes()->attach(2);;

        $susan = new Comment;
        $susan->text = "I will join you";
        $susan->user_id = 4;
        $susan->post_id = 5;
        $susan->save();
        $susan->likes()->attach(1);
        $susan->likes()->attach(2);
        $susan->likes()->attach(3);

        $jane = new Comment;
        $jane->text = "I love cake!!!";
        $jane->user_id = 5;
        $jane->post_id = 2;
        $jane->save();
        $jane->likes()->attach(1);
        $jane->likes()->attach(2);
        $jane->likes()->attach(3);
        $jane->likes()->attach(4);

        $comments = Comment::factory()->count(10)->create();
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