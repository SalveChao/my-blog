<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Like;
use App\User;

class Post extends Model
{
    public $with = 'likes'; //イーガーロード(リレーション) Call to undefined relationship [user] on model

	use SoftDeletes;

    protected $fillable=[
    	'title', 'image', 'content', 'published_at','user_id', 'category_id'
    ];

/**
* delete image from posts
*/
    public function deleteImage()
    {
    	Storage::delete($this->image);
    }

    public function categories()
    {
    	return $this->belongsToMany('App\Category');
    }
/** check if post has category
*	@return boot
*/
    public function hasCategory($categoryId)
    {
    	return in_array($categoryId, $this->categories->pluck('id')->toArray());
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function favorited()
    {
        return (bool) Favorite::where('user_id', Auth::id())
                        ->where('post_id', $this->id)
                        ->first();
    }

    public function likes() {
        return $this->hasMany('App\Like');
    }


}
