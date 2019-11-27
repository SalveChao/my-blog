<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdatePostsRequest;
use App\Http\Requests\CreatePostsRequest;
use App\Http\Requests\ArchivePostsRequest;
use App\Category;
use App\Post;
use App\Models\Archive;
use App\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Like;
use App\Http\Middleware\RedirectIfAuthenticated;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::withCount('comments')->orderBy('created_at', 'desc')->paginate(5);
        $archives_list = Archive::getArchiveList();
        $categories = Category::has('posts')->get();
        return view('posts.index')->with('posts', $posts)->with('categories', $categories)->with('archives_list', $archives_list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage-posts.create')->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        if ($request->hasFile('image')) {
            $image =$request->image->store('posts', ['disk' => 'public']);

            $data = Post::create([
             'title' => $request->title,
             'content' => $request->content,
             'published_at' => $request->published_at,
             'image' => $image,
            ]);
        } else {
            $data = Post::create([
                 'title' => $request->title,
                 'content' => $request->content,
                 'published_at' => $request->published_at,
             ]);
        }
        if ($request->categories) {
            $data->categories()->attach($request->categories);  //中間テーブルに挿入
        }
        session()->flash('success', '投稿しました');

       return  redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('likes');   //eager load
        $defaultCount = count($post->likes);
        $defaultLiked = $post->likes->where('user_id', Auth::user()->id)->first();
        
            if(isset($defaultLiked)) {
                $defaultLiked == false;
            }else {
                $defaultLiked == true;
            }
        
        $comments =Comment::where('post_id', $post)->get();
        $archives_list = Archive::getArchiveList();
        $categories = Category::has('posts')->get();
        return view('posts.show')->with('post', $post)->with('comments', $comments)->with('posts', Post::orderBy('created_at', 'desc')->paginate(5))->with('categories', $categories)->with('archives_list', $archives_list)->with('defaultLiked', $defaultLiked)->with('defaultCount', $defaultCount);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // dd($post->categories->pluck('id')->toArray());
        return view('manage-posts.create')->with('post', $post)->with('categories', Category::all())->with('userAuth', $userAuth);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostsRequest $request, Post $post)
    {
        $data = $request->only(['title', 'published_at', 'content']);
        if ($request->hasFile('image')) {
            $image = $request->image->store('posts');
            $post->deleteImage();
            $data['image'] = $image;
        }
        if ($request->categories) {
            $post->categories()->sync($request->categories);
        }
        $post->update($data);
        session()->flash('success', '編集しました');
        return redirect(route('posts.index'));
    }

    public function like(Post $post, Request $request) {

        $like = Like::create([
            'user_id' => $request->user_id,
            'post_id' => $post->id
        ]);
        
        $LikeCount = count(Like::where('post_id', $post->id)->get());

        return response()->json([]);
    }

    public function unlike(Post $post, Request $request) {

        $like = Like::where('user_id', $request->user_id)
            ->where('post_id', $post->id)->first();
        $like->delete();    

        $likeCount = count(Like::where('post_id', $post->id)->get());
        return response()->json([]);
    }

    public function archives(Request $request)
    {
       $year = $request->year;
       $month = $request->month;

       $articles = Post::latest();
       $articles->whereMonth('created_at', Carbon::parse($month)->month);
       $articles->whereYear('created_at', $year);       //連想配列のキーpostsに５つの記事を代入
       $data['articles'] = $articles->paginate(5);

       //サイドバーアーカイブ用のデータをモデルから引っ張っている
       $archives_list = Archive::getArchiveList();
       $posts = Post::orderBy('created_at', 'desc')->take(5)->get();
        $categories = Category::has('posts')->get();
       return view('posts/archives')->with('data', $data['articles'])->with('archives_list', $archives_list)->with('categories',$categories)->with('posts', $posts)->with('articles', $articles);
    }
}
