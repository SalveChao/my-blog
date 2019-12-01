@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="POST" id="deletePostsForm">
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

<div card class="card-header">
	記事一覧
	<a href="{{ route('manage-posts.create') }}" class="btn btn-success btn-sm float-right">投稿</a>
</div>
@if($posts->count()>0)
<div class="card-body">
	<button class="btn btn-danger btn-sm delete-all mb-2" data-url="">一括ゴミ箱</button>
	<table class="table table-sm">
		<thead>
			<th><input type="checkbox" id="check_all"></th>
			<th>タイトル</th>
			<th>コメント</th>
			<th>公開日</th>
			<th>操作</th>
		</thead>
		<tbody>
			@foreach($posts as $post)
			<tr>
				<td><input type="checkbox" class="checkbox" data-id="{{ $post->id }}"></td>
				<td>{{ $post->title }}</td>
				<td>{{ $post->comments()->count() }}</td>
				<td>{{ ($post->created_at)->format('Y/m/d') }}</td>
				<td>
					<span><a href="{{ route('posts.show', [$post->id]) }}" class="btn btn-info btn-sm">表示</a></span>
					<span><a href="{{ route('manage-posts.edit', [$post->id]) }}" class="btn btn-warning btn-sm">編集</a></span>
					<button　type="submit"  class="btn btn-danger btn-sm" onclick="handleDelete({{ $post->id }})" style="color: black;">
                    ゴミ
					</button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{{ $posts->links() }}
</div>
@else
<p class="mt-2 pl-3">現在、投稿記事はありません。</p>
@endif
@endsection

@section('scripts')
 <script>
  //modal用script
 	function handleDelete(id){
    var form = document.getElementById('deletePostsForm')
    form.action = '/manage-posts/' + id
 		$('#deleteModal').modal('show')
 	}
  //一括削除
  $(document).ready(function () {

    $('#check_all').on('click', function(e) {
     if($(this).is(':checked',true))
     {
        $(".checkbox").prop('checked', true);
     } else {
        $(".checkbox").prop('checked',false);
     }
    });

     $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#check_all').prop('checked',true);
        }else{
            $('#check_all').prop('checked',false);
        }
     });

    $('.delete-all').on('click', function(e) {

        var idsArr = [];
        $(".checkbox:checked").each(function() {
            idsArr.push($(this).attr('data-id'));
        });

        if(idsArr.length <=0)
        {
            alert("最低1つ選択してください。.");
        }  else {

            if(confirm("指定の記事をゴミ箱へ移動しますか？")){

                var strIds = idsArr.join(",");

                $.ajax({
                    url: "{{ route('post.multiple-delete') }}",
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: 'ids='+strIds,
                    success: function (data) {
                        if (data['status']==true) {
                            $(".checkbox:checked").each(function() {
                                $(this).parents("tr").remove();
                            });
                            alert(data['message']);
                        } else {
                            alert('エラー処理発生');
                        }
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });
            }
        }
    });

    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        onConfirm: function (event, element) {
            element.closest('form').submit();
        }
    });
});
 </script>
@endsection