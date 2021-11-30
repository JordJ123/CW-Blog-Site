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
    }
}
