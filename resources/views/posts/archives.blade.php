@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
@endsection

@section('content')

<div class="font-weight-bold navbar avbar-light" style="background-color: #e3f2fd;">
アーカイブ：{{$year_month }}
</div>

@foreach($data as $article)
<div class="card mt-2">
  <div card class="card-header"><h2><a href="{{ route('posts.show', ['id'=>$article->id]) }}">{{ $article->title }}</a></h2></div>
  <div class="card-body">
    <table class="table">
      <tbody><tr><td>{!!  nl2br($article->content) !!}</td></tr></tbody>
    </table>
    <span>{{ $article->created_at }}</span>
    <br>
　　</div>
</div>
@endforeach

@endsection
