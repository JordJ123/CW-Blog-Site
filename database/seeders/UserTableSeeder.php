<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jordan = new User;
        $jordan->name = "Jordan123";
        $jordan->email = "jordan@email.com";
        $jordan->password = "Password123!";
        $jordan->save();

        $bob = new User;
        $bob->name = "Bob123";
        $bob->email = "bob@email.com";
        $bob->password = "Password123!";
        $bob->save();

        $steve = new User;
        $steve->name = "Steve23";
        $steve->email = "steve@email.com";
        $steve->password = "Password123!";
        $steve->save();

        $susan = new User;
        $susan->name = "Susan123";
        $susan->email = "susan@email.com";
        $susan->password = "Password123!";
        $susan->save();

        $jane = new User;
        $jane->name = "Jane123";
        $jane->email = "jane@email.com";
        $jane->password = "Password123!";
        $jane->save();

        $users = User::factory()->count(10)->create();
    }
}
