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
			<tbody>
				@if($post->image)
				<tr><td class="text-center"><img src="{{ asset('/storage/'.$post->image) }}" style="max-width: 200px;"></td></tr>
				@endif
				<tr><td>{!! $post->content !!}</td></tr>
			</tbody>
		</table>
	</div>	
	<div class="card-footer">
	    <span class="pr-2">投稿：{{ $post->created_at }}</span>
			カテゴリ:<span class="btn btn-sm ">
	    		@foreach($post->categories as $category)
	    		<a href="{{ route('category.single', ['id' => $category->id]) }}">
	    		{{ $category->name }}
		    	</a>
	    		@endforeach
		    	<like 
		    	:post-id="{{json_encode($post->id) }}"
		    	:user-id="{{json_encode(Auth::id()) }}"
		    	:default-liked="{{json_encode($defaultLiked) }}"
		    	:default-count="{{ json_encode($defaultCount) }}"
		    	></like>
	    	</span>
	    </div>
</div>
@include('partials.comments')
@endsection

