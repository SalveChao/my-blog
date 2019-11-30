@extends('layouts.app')

@section('content')
<div card class="card-header">
	登録者一覧
</div>
<div class="card-body">
	<table class="table table-sm">
		<thead>
			<th>グラバター</th>
			<th>名前</th>
			<th>役割</th>
			<th>権限</th>
		</thead>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td><img width="25px" height="25px" style="border-radius: 50%;" src="{{ Gravatar::src($user->email) }}" alt=""></td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->role }}</td>
				<td>
					@if(Auth::id() !== $user->id && $user->role !== 'admin' )
					<form action="{{ route('users.make-admin', ['id' => $user->id]) }}" method="POST">
					@csrf
					<button type="submit" class="btn btn-success btn-sm">管理者権限付与</button>
					</form>
					@elseif($user->role == 'admin')
					管理者
					@else
					
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
　　</div>
@endsection