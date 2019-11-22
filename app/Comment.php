<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'name', 'email', 'comment',
	];

	public function post()
	{
	    return $this->belongsTo('App\Post');
	}

}
