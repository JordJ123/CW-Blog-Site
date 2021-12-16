<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\EmailService;
use App\Services\Facebook;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(EmailService::class, function($app) {
            $sender = new User;
            $sender->name = "Posts R Us";
            $sender->email = "postsrus@email.com";
            return new EmailService($sender);
        });
        app()->singleton(Facebook::class, function($app) {
            return new Facebook("W8jS92mS0nw)WnW220JS!22233dWjwn2,,@n2n(2008383nJ£Hjiu&FD5gyfH8h");
        });
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
