@extends('app')
@section('content')
	<div class="page-header">
		<h1>Kasutajad</h1>
	</div>

	<table class="table">
		<tr>
			<th>Nimi</th>
			<th>E-mail</th>
			<th>Roll</th>
			<th>Treeninguid</th>
		</tr>
		@foreach ($users as $user)
			<tr>
				<td>
					<a href="{{ url('admin/users', array($user->id, 'edit') )}}">
						{{ $user->name }}
					</a>
				</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->role }}</td>
				<td>{{ $user->training_count }}</td>
			</tr>
		@endforeach

	</table>

@stop