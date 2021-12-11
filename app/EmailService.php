<?php

namespace App;

use Mail;
use App\Models\User;

class EmailService
{

    private $serviceSender;

    public function __construct(User $serviceSender) {
        $this->serviceSender = $serviceSender;
    }

    public function email(User $recipent, $subject, $view, $data) {
        Mail::send($view, $data, function($message) use ($recipent, $subject) {
            $message->to($recipent->email, $recipent->name)
                ->subject($subject);
            $message->from($this->serviceSender->email, $this->serviceSender->name);
        });
    }

}