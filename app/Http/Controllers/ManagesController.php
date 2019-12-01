<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdatePostsRequest;
use App\Http\Requests\CreatePostsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Post;
use App\Category;
use App\Comment;


class ManagesController extends Controller
{
    // use SoftDeletes; これはモデルに指定する模様。なので不要

    public function allposts()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('manage-posts/allposts')->with('posts', $posts);
        // ('posts.index', compact('posts'));と言う記述もある
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

       return  redirect(route('manage-posts.allposts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($post->categories->pluck('id')->toArray());
        $post = Post::find($id);
        return view('manage-posts.create')->with('post', $post)->with('categories', Category::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostsRequest $request, $id)
    {
        $post = Post::find($id);
        $data = $request->only(['title', 'published_at', 'content']);
        if ($request->hasFile('image')) {
            $image = $request->image->store('posts');
            $post->deleteImage();
            $data['image'] = $image;
        }
        if ($request->categories) {
            $post->categories()->sync($request->categories);
        }
        $post->update($data);   //update_atも更新
        session()->flash('success', '編集しました');
        return redirect()->route('manage-posts.allposts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post =Post::withTrashed()->where('id', $id)->firstOrFail();
        // $comments = Comment::where('post_id', $id)->get();
        $comments = Post::find($id)->comments()->where('post_id', $id)->get();

        //trashed()メソッドはソフトデリートされているかの確認(softdeleteされていれば完全削除)
        if ($post->trashed()) {
            $comments->delete();
            $post->deleteImage();  //フォルダからもimgを削除
            $post->forceDelete();
        } else {                //まだソフトデリートされていない
            if($comments) {         
                foreach($comments as $comment) {
                    $comment->post()->dissociate($post);
                }
                $post->delete();
            }
        }
        session()->flash('success', '削除しました。');
        return redirect()->back();
    }

    public function trashed() {
        $trashed = Post::onlyTrashed()->paginate(30);
        return view('manage-posts/trash')->withPosts($trashed);  // with('posts', $trashed)
        }

    public function deleteMultiple(Request $request) {
        $ids = $request->ids;

        Post::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status'=>true,'message'=>"一括削除しました。"]);

        }

    public function forceDeleteMultiple(Request $request) {
        $ids = $request->ids;

        Post::whereIn('id',explode(",",$ids))->forceDelete();

        return response()->json(['status'=>true,'message'=>"一括削除しました。"]);

        }


     public function restore($id) {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        $post->restore();

        session()->flash('success', '回復しました');
        return redirect()->back();
    }

}
