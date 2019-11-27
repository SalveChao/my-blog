<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Auth;
use App\Models\Archive;

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
        $archives_list = Archive::getArchiveList();
        if(Auth::user()->role !== 'Admin'){
        return view('/posts/index')->with('posts', $posts)->with('categories', $categories)->with('archives_list', $archives_list);
        } else {
        return view('manage-posts/allposts')->with('posts', $posts)->with('categories', $categories);
        }
    }
}
