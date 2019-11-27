@extends('layouts.app')
<!-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> -->
@section('comments')
<div class="card card-default">
	<div card class="card-header">
		<h2>コメント一覧</h2>
	</div>
	@if($comments->count()>0)
	<div class="card-body">
		<table class="table">
			<thead>
				<th width="100px">コメント削除</th>
				<th>名前</th>
				<th>コメント</th>
				<th>記事</th>
			</thead>
			<tbody>
				@foreach($comments as $comment)
				<tr>
					<td><button class="btn btn-danger btn-sm" onclick="handleDelete({{ $comment->id }})">削除</button></td>
					<td>{{ $comment->name}}</td>
					<td>{!! substr(strip_tags($comment->comment), 0) !!}</td>
					@if($comment -> post)
					<td><a href="{{ route('posts.show', ['id'=> $comment->post->id ]) }}">{{ $comment->post->title }}</a></td>
					@else
					<td><p>ゴミ箱</p></td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
		<br>
　　</div>
	@else
	<p class="mt-2 px-3">コメントはありません。</p>
	@endif
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="POST" id="deleteCommentForm">
    @csrf
    @method('DELETE')
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">削除</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        削除します。よろしいですか？
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          <button  type="submit" class="btn btn-primary">削除</button>
      </div>
     </div>
     </form>
  </div>
</div>

@if (Auth::check())
		    <div class="panel-footer">
		    	{{ $comments->links() }}
		    </div>
			@endif
@endsection

@section('scripts')
 <script>
 	function handleDelete(id){
    var form = document.getElementById('deleteCommentForm')
    form.action = '/comments/' + id
 		$('#deleteModal').modal('show')
 	}
 </script>
@endsection
