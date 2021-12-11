<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        $jordan->password = Hash::make("Password123!");;
        $jordan->isAdmin = true;
        $jordan->save();

        $bob = new User;
        $bob->name = "Bob123";
        $bob->email = "bob@email.com";
        $bob->password = Hash::make("Password123!");
        $bob->isAdmin = false;
        $bob->save();

        $steve = new User;
        $steve->name = "Steve23";
        $steve->email = "steve@email.com";
        $steve->password = Hash::make("Password123!");
        $steve->isAdmin = false;
        $steve->save();

        $susan = new User;
        $susan->name = "Susan123";
        $susan->email = "susan@email.com";
        $susan->password = Hash::make("Password123!");
        $susan->isAdmin = false;
        $susan->save();

        $jane = new User;
        $jane->name = "Jane123";
        $jane->email = "jane@email.com";
        $jane->password = Hash::make("Password123!");
        $jane->isAdmin = false;
        $jane->save();

        $users = User::factory()->count(10)->create();
    }
}
