@extends('app')
@section('content')
	<div class="page-header">
		<h1>Kasutajad</h1>
	</div>

	<table class="table">
		<tr>
			<th>Nimi</th>
			<th>E-mail</th>
		</tr>

		@foreach ($users as $user)
			<tr>
				<td>
					<a href="{{ url('admin/users', array($user->id, 'edit') )}}">
						{{ $user->name }}
					</a>
				</td>
				<td>{{ $user->email }}</td>
			</tr>
		@endforeach

	</table>

@stop