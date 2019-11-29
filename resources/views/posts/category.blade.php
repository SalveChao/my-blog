@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
@endsection

@section('content')

<div class="nav navbar navbar-light text-center font-weight-bold" style="background-color: #e3f2fd;">カテゴリ：{{ $category->name }}</div>

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
  <hr>
    <span class="pl-3 pb-2">{{$post->created_at}}　コメント数：{{$post->comments->count()}}</span>
　</div>
 @endforeach
@endsection
