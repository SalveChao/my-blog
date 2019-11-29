<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Comment;
use App\Models\Archive;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manage-posts/categories_index')
            ->with('categories', Category::all())
            ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage-posts/category_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = new Category;
        $category->name = request()->name;
        $category->save();
        session()->flash('success', 'カテゴリを作成しました');
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $categories = Category::has('posts')->get();
        // show('posts/category')->with('categories', $categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('manage-posts/category_create')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->save();
        session()->flash('success', '更新しました');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->posts->count() > 0) {
            session()->flash('error', '記事に使われているため削除不可能');
            return redirect(route('categories.index'));
        }
        $category->delete();
        session()->flash('success', '削除しました');
        return redirect(route('categories.index'));
    }
/**
* カテゴリ一括削除機能
*/
     public function deleteMultiple(Request $request){

        $ids = $request->ids;

        Category::whereIn('id',explode(",",$ids))->delete();

        return response()->json(['status'=>true,'message'=>"一括削除しました。"]);

    }

    public function category($post_id)
    {
        $category = Category::find($post_id);
        
        $builder = Post::withCount('comments')->orderBy('created_at', 'desc');
        $posts = $builder->simplepaginate(5);
        $feeds = $builder->take(5)->get();
        
        $archives_list = Archive::getArchiveList();
        return view('posts/category')
            ->with('category', $category)
            ->with('posts', $posts)
            ->with('categories',Category::has('posts')->get())
            ->with('archives_list', $archives_list)
            ->with('feeds', $feeds);
    }
}
