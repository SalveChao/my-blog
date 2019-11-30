@extends('layouts.app')

@section('content')
@include('partials.errors')
<div class="card card-default">
	<div card class="card-header">
	{{ isset($post) ? '記事編集' : '記事作成' }}
	</div>
	<div class="card-body">
		<form action="{{ isset($post) ? route('manage-posts.update', [$post->id]) : route('manage-posts.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		@isset($post) @method('PUT') @endisset
		<div class="form-group row">
			<label for="title" class="col-sm-2">タイトル</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="title" id="title" value="@if(isset($post)){{ $post->title }} @else{{ old('title') }}@endif">
			</div>
		</div>
		<div class="form-group">
			<label for="content" class="my-1">記事内容</label>
			<input id="content" type="hidden" name="content" value="
			@if(isset($post)){{ $post->content }} @else {{ old('content') }}@endif">
				
			</input>

  			<trix-editor input="content"></trix-editor>
		</div>
		<div class="form-group">
			<label for="image" class="my-1">画像</label>
			<input type="file" class="form-control" name="image" id="image">
			</input>
			@isset($post->image)
				<p><img class="mt-2" src="{{ asset('/storage/' .$post->image) }}" width="25%"></p>
			@endisset
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="published_at" >公開日</label>
				<input type="text" class="form-control" name="published_at" id="published_at" value="@isset($post){{ $post->published_at }}@endisset">
			</div>
			@if($categories->count()>0)
			<div class="form-group col-md-6">
				<label for="categories" >ラベル</label><br>
				<select type="text" class="form-control categories-selector" name="categories[]" id="categories"  value="
				@if(isset($post)) {{$post->categories }}@else{{ old('categories[]')}} @endif
				" multiple>
					@foreach($categories as $category)
						<option value="{{ $category->id }}" @if(isset($post) && $post->hasCategory($category->id)) selected @endif>
							{{ $category->name }}
						</option>
					@endforeach
				</select>
			</div>
			@endif
		</div>
		<div class="form-group">
		<button type="submit" class="btn btn-success">送信</button>
		</div>
		</form>
　　</div>
</div>
@endsection

@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script>
		import flatpickr from "flatpickr";
		flatpickr('#published_at', {enableTime: true});
		 (document).ready(function() {
    	 ('.categories-selector').select2();
		});
	</script>
@endsection

@section('css')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection