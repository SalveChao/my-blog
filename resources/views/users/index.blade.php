@extends('layouts.app')

@section('content')
<div card class="card-header">
	登録者一覧
</div>
<div class="card-body">
	<table class="table table-sm">
		<thead>
			<th>グラバター</th>
			<th></th>
			<th>役割</th>
			<th>コメント</th>
			<th>権限</th>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td><img width="25px" height="25px" style="border-radius: 50%;" src="{{ Gravatar::src($user->email) }}" alt=""></td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->role }}</td>
				<td>何か</td>
				<td>
					@if(!$user->isInitiator())
					<form action="{{ route('users.make-admin', $user->id) }}" class="btn btn-info " method="POST">
						@csrf
					管理者権限付与
					</form>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
　　</div>
@endsection