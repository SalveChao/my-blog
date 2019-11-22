<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArchivePostsRequest;
use Carbon\Carbon;

class BlogsController extends Controller
{
    // public function blognews
    // {
    // 	$post = App\Post::orderBy('created_at', 'desc')->paginate(5);
    // }

    public function archives(ArchivePostsRequest $request)
    {
	   $month = $request->month;
	   $year = $request->year;

	   $data['archive_name'] = 'Archives from '.$month.', '.$year;

	   $posts = Post::latest();
	   $posts->whereMonth('created_at', Carbon::parse($month)->month);
	   $posts->whereYear('created_at', $year);

	   $data['posts'] = $posts->paginate(10);

	   return view('posts.index', $data);
    }
}
