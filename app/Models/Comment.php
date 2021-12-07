<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $appends = ['name', 'likeCount', 'isUser', 'alreadyLiked'];

    public function getNameAttribute() {
        return $this->user()->first()->name;
    }

    public function getLikeCountAttribute() {
        return $this->likes()->count();
    }

    public function getIsUserAttribute() {
        return $this->user()->first() == auth()->user();
    }

    public function getAlreadyLikedAttribute() {
        $alreadyLiked = false;
        foreach ($this->likes()->get() as $user) {
            if ($user->id == auth()->user()->id) {
                $alreadyLiked = true;
                break; 
            }
        }
        return $alreadyLiked;   
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function post() {
        return $this->belongsTo('App\Models\User');
    }

    public function likes() {
        return $this->morphToMany(User::class, "likeable");
    }
    
}
