
@extends('layouts.app')
@section('content')
<div card class="card-header">
	ゴミ箱一覧
</div>
@if($posts->count() > 0)
<div class="card-body">
	<button class="btn btn-danger btn-sm forcedelete-all mb-2" data-url="">一括削除</button>
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
				<td><input type="checkbox" class="checkbox" data-id="{{$post->id}}"></td>
				<td>{{ $post->title }}</td>
				<td>{{ $post->comments()->count() }}</td>
				<td>{{ ($post->created_at)->format('Y/m/d') }}</td>
				<td>
					<form style="display: inline;" action="{{ route('restore-post', $post->id) }}"  method="POST">
					@csrf
					@method('PUT')
					<button  type="submit" class="btn btn-sm btn-info">元に戻す</button>
					</form>
					<button　type="submit"  class="btn btn-danger btn-sm" onclick="handleDelete({{ $post->id }})">削除</button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@else
	<p class="mt-2 px-2">現在、ゴミ箱は空です。</p>
	@endif
	{{ $posts->links() }}
　</div>

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
@endsection

@section('scripts')
 <script>
 	function handleDelete(id){
    var form = document.getElementById('deletePostsForm')
    form.action = 'manage-posts/' + id
 		$('#deleteModal').modal('show')
 	}

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

    $('.forcedelete-all').on('click', function(e) {

        var idsArr = [];
        $(".checkbox:checked").each(function() {
            idsArr.push($(this).attr('data-id'));
        });

        if(idsArr.length <=0)
        {
            alert("最低1つ選択してください。.");
        }  else {

            if(confirm("指定の記事を一括削除しますか？")){

                var strIds = idsArr.join(",");

                $.ajax({
                    url: "{{ route('post.multiple-forcedelete') }}",
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