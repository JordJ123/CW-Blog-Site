<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $appends = ['name', 'likeCount', 'isUser', 'alreadyLiked', 'image', 
        'comments', 'newComment'];

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

    public function getImageAttribute() {
        return $this->image()->first();   
    }

    public function getCommentsAttribute() {
        return $this->comments()->get();
    }

    public function getNewCommentAttribute() {
        return "";
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function image() {
        return $this->hasOne('App\Models\Image');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }

    public function likes() {
        return $this->morphToMany(User::class, "likeable");
    }

}
