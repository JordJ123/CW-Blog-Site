<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jordan = new Post;
        $jordan->text = "Hello world!";
        $jordan->user_id = 1;
        $jordan->save();
        
        $bob = new Post;
        $bob->text = "I like cake";
        $bob->user_id = 2;
        $bob->save();
        $bob->likes()->attach(1);

        $steve = new Post;
        $steve->text = "I dislike cake";
        $steve->user_id = 3;
        $steve->save();
        $steve->likes()->attach(1);
        $steve->likes()->attach(2);

        $susan = new Post;
        $susan->text = "Goodbye everyone";
        $susan->user_id = 4;
        $susan->save();
        $susan->likes()->attach(1);
        $susan->likes()->attach(2);
        $susan->likes()->attach(3);

        $jane = new Post;
        $jane->text = "Going for a walk";
        $jane->user_id = 5;
        $jane->save();
        $jane->likes()->attach(1);
        $jane->likes()->attach(2);
        $jane->likes()->attach(3);
        $jane->likes()->attach(4);

        $posts = Post::factory()->count(10)->create();
    }
}
