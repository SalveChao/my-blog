<?php

namespace App;

use App\User;
use App\Post;
use Illuminate\Database\Eloquent\Model;


class Like extends Model
{
    public function post()
    {
    	return $this->belongsTo('post');
    }

    public function user()
    {
    	return $this->belongsTo('user');
    }

    public $with = ['user']; //イーガーロード
}
