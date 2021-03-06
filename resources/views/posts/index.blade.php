@extends('layouts.app2')

@section('content')

@foreach($posts as $post)
<div class="card mb-2">
  <div card class="card-header">
    <h3><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h3>
  </div>
  <div class="card-body">
		<table class="table table-sm">
  		<tbody>
        <tr>{!! $post->content !!}</tr>
  	  </tbody>
	  </table>
	  </div>
  <div class="card-footer">
  		<span class="px-2"><b>更新：</b>{{ ($post->created_at)->format('Y/m/d G時i分') }}</span>
      <span><b>コメント数：</b>{{ $post->comments_count }}</span>
  </div>
</div>
@endforeach
  {{ $posts->links() }}
@endsection

