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
  			<tr>
  				<td>{{ ($post->created_at)->format('Y/m/d G時i分') }}</td>
          <td>コメント数：{{ $post->comments_count }}</td>
          <td><likes-component></likes-component></td>
          <td><init></init></td>
  			</tr>
  	  </tbody>
	  </table>
  </div>
  <br>
</div>
  @endforeach

{{ $posts->links() }}
@endsection

