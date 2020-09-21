<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function comments()
    {
    	return $this->hasMany(Comment::class);
    }
    public function category()
    {
    	return $this->belongsTo(Category::class,'cat_id','id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    public function commentsCount(){

    	return $this->hasMany(Comment::class);
    }
}
