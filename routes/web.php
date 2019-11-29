<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return view('welcome');});

//guest
Route::resource('/posts', 'PostsController', ['only'=>['index','show']]);
Route::get('blog-news', 'BlogsController@blognews')->name('blognews');
Route::get('/posts/archives/{year}/{month}', 'PostsController@archives')->name('archives');
Route::get('/posts/category/{id}', 'CategoriesController@category')->name('category.single');

//comments
Route::resource('/comments', 'CommentsController', ['except' => ['index', 'delete', 'edit', 'update', 'store']]);
Route::post('posts/{post_id}', 'CommentsController@store')->name('comments.store');


Auth::routes();

//Likes
Route::get('get_auth_user_data', function() {
  return Auth::user();
});

//Admin
Route::middleware(['auth'])->group(function () {

	Route::get('/home', 'HomeController@index')->name('home');

	//manage
	Route::resource('/manage-posts', 'ManagesController',['except'=>['index', 'show']]);
	Route::get('manage-posts/allposts', 'ManagesController@allposts')->name('manage-posts.allposts');
	Route::get('manage-posts/trash', 'ManagesController@trashed')->name('trashed-posts');
	Route::get('manage-posts/comments', 'CommentsController@index')->name('comments.index');
	//categoy
	Route::resource('/manage-posts/categories', 'CategoriesController',['except' =>['index', 'create', 'edit']]);
	Route::get('manage-posts/categories_index', 'CategoriesController@index')->name('categories.index');
	Route::get('manage-posts/category_create', 'CategoriesController@create')->name('categories.create');
	Route::get('manage-posts/{category}/category_edit', 'CategoriesController@edit')->name('categories.edit');
	//users
	Route::get('manage-posts/users', 'UsersController@index')->name('users.index');
	Route::post('manage-posts/users.{user}/make-admin', 'UsersController@makeAdmin')->name('users.make-admin');

	// Route::delete('postsDeleteAll', 'ManagesController@deleteAll');
	Route::put('restore-post/{post}', 'ManagesController@restore')->name('restore-post');
	Route::delete('delete-multiple-post', 'ManagesController@deleteMultiple')->name('post.multiple-delete');
	Route::delete('forcedelete-multiple-post', 'ManagesController@forceDeleteMultiple')->name('post.multiple-forcedelete');

	//categories
	Route::delete('delete-multiple-category', 'CategoriesController@deleteMultiple')->name('category.multiple-delete');

	//comments

	Route::delete('comments/{id}', 'CommentsController@destroy');
});


//Auth
Route::group(['middleware' => ['auth']], function () {

	Route::get('users/profile', 'UsersController@edit')->name('users.edit-profile');
	Route::put('users/profile', 'UsersController@update')->name('users.update-profile');
	Route::post('/posts/{post}/Like', 'PostsController@like');
	Route::post('/posts/{post}/unlike', 'PostsController@unlike');
	Route::get('try', function() {return App\Post::with('user', 'likes')->get();});
});