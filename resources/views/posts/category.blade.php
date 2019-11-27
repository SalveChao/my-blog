@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
@endsection

@section('content')

@foreach($category->posts as $post)
<div class="card mb-1">
  <div card class="card-header">
    <h3><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h3>
  </div>
  <div class="card-body">
	<table class="table table-sm">
		<tbody>
    		<tr>{!! $post->content!!}</tr>
	  </tbody>
  </table>
  </div>
    <span class="pl-2"><like post-id="{{ json_encode($post->id) }}"></like></span>
    <span class="pl-2">{{$post->created_at}}　コメント数：{{$post->comments->count()}}</span>
　</div>
 @endforeach
@endsection
