@extends('layouts.app2')

@section('title')
	<title>{{ $post->title . " | " . config('app.name', 'Laravel') }}</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
@endsection

@section('content')
<div class="card">
	<div card class="card-header"><h2>{{ $post->title }}</h2></div>
	<div class="card-body">
		<table class="table">
			<tbody><tr><td>{!! $post->content !!}</td></tr></tbody>
		</table>
		<div><a  href=""><img class="img-fluid" src="{{ Storage::url($post->image) }}"></a></div>
		<br>

	    <div class="panel-footer">
	    	<span class="pr-2">投稿：{{ $post->created_at }}</span>
			カテゴリ:<span class="btn btn-sm ">
	    		@foreach($post->categories as $category)
	    		<a href="{{ route('category.single', ['id' => $category->id]) }}">
	    		{{ $category->name }}
		    	</a>
	    		@endforeach
		    	<init></init>
	    	</span>
	    </div>

　　</div>
</div>
@include('partials.comments')
@endsection

