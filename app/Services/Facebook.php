<?php

namespace App\Services;

class Facebook 
{

    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function uploadPost(Post $post)
    {
        $imagePath = null;
        if ($post->image()->first() != null) {
            $imagePath = 'images/' + $post->image()->first()->path;
        }
        $post = collect(['apiKey' => $this->apiKey, 'text' => $post->text, 
            'image' => $imagePath]);
        dd($post);
    }

}