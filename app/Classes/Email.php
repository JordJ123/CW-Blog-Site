<?php

namespace App\Classes;

use Mail;
use App\Models\User;

class Email
{

    private $sender;
    private $recipent;
    private $subject;
    private $view;
    private $data;

    public function __construct(User $sender, User $recipent, 
        $subject, $view, $data) {
        $this->sender = $sender;
        $this->recipent = $recipent;
        $this->subject = $subject;
        $this->view = $view;
        $this->data = $data;
    }

    public function send() {
        Mail::send($this->view, $this->data, function($message) {
            $message->to($this->recipent->email, $this->recipent->name)
                ->subject($this->subject);
            $message->from($this->sender->email, $this->sender->name);
        });
    }

}