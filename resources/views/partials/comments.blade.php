<div class="card mt-2">
	<div card class="card-header">
		コメント
	</div>
	<div class="row mt-3 card-body">
		<div id="comment-form" class="col-md-8 col-md-offset-2">
			<form action="{{ route('comments.store', ['id'=> $post->id]) }}" method="POST">
				@csrf
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="name">名前</label>
					<div class="col-sm-10">
						<input type="name" class="form-control" name="name" id="name">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="email">Email</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="email" id="email">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="comment">コメント</label>
					<div class="col-sm-10">
						<textarea type="comment" class="form-control" name="comment" id="comment"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-8"></div>
					<div class="col-sm-4">
					<button type="submit" class="btn btn-info mt-2 form-control">コメント送信</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row card-body">
		<div class="col-md-8 col-sm-offset-2">
			<h3>コメント</h3>
			<hr>
			<div class="comment">
			@foreach($post->comments as $comment)
				<div class="commenter-info mb-2">

					<img src="{{ Gravatar::src($comment->email)}}" class="commenter-image" alt="">
					<div class="commenter-name">
						<span>{{ $comment->name . ' さん'}}</span>
						<span class="commenter-time">{{ $comment->created_at }}</span>
					</div>
					<div class="comment-content">{{ $comment->comment }}</div>
				</div>
			@endforeach
			</div>

		</div>
	</div>
</div>