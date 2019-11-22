<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);
        $categories =Category::all();

        if(!Auth::user()->role == 'Initiator'){
        return view('home')->with('posts', $posts)->with('categories', $categories);
        } else {
        return view('manage-posts/allposts')->with('posts', $posts)->with('categories', $categories);
        }
    }
}
