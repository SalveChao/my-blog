@extends('layouts.app')

@section('content')
<div class="text-right">
  <a href="{{ route('categories.create') }}" class="btn btn-success btm-sm mb-2 mr-1 text-right">カテゴリ追加</a>
</div>
      
<div class="card d-flex justify-content-end mb-2">
    <div class="card-body">
	    <table class="table table-sm">
      @if($categories->count() > 0)
        <button class="text-left btn btn-danger btn-sm delete-all mb-2" data-url="">一括削除</button>
    	<thead>
          <th><input type="checkbox" id="check_all"></th>
          <th>カテゴリ</th>
          <th>記事数</th>
          <th>　編集</th>
          <th>　削除</th>
        </thead>
		<tbody>
  			@foreach($categories as $category)
  			<tr>
          <td><input type="checkbox" class="checkbox" data-id="{{$category->id}}"></td>
  				<td>{{ $category->name }}</td>
          <td>{{ $category->posts->count() }}</td>
          <td><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">編集</a></td>
          <td><button class="btn btn-danger btn-sm" onclick="handleDelete({{ $category->id }})">削除</button></td>
  			</tr>
  			@endforeach
		</tbody>
	  </table>
        @else
        <p class="mt-2 mx-3">カテゴリを作成してください。</p>
        @endif
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="POST" id="deleteCategoryForm">
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
    var form = document.getElementById('deleteCategoryForm')
    form.action = 'manage-posts/categories/' + id
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

        $('.delete-all').on('click', function(e) {

            var idsArr = [];
            $(".checkbox:checked").each(function() {
                idsArr.push($(this).attr('data-id'));
            });

            if(idsArr.length <=0)
            {
                alert("最低1つ選択してください。.");
            }  else {

                if(confirm("指定のカテゴリを一括削除しますか？")){

                    var strIds = idsArr.join(",");

                    $.ajax({
                        url: "{{ route('category.multiple-delete') }}",
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