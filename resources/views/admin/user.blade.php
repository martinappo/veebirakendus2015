@extends('app')

@section('content')
	<div class="page-header">
		<h1>{{$user->name}}</h1>
	</div>

	<table class="table">
		<tr>
			<th>Nimi</th>
			<td>{{ $user->name }}</td>
		</tr>
		<tr>
			<th>E-mail</th>
			<td>{{ $user->email }}</td>
		</tr>
		<tr>
			<th>Roll</th>
			<td>
				{!! Form::model($user, ['method' => 'PATCH', 'url' => 'admin/users/' .$user->id]) !!}
				<div class="input-group">
					<span class="input-group-btn">
						{!! Form::submit('Kinnita' , ['class' => 'btn btn-primary']) !!}
					</span>
					{!! Form::select('role', array('user'=>'user','admin'=>'admin'), null, ['class' => 'form-control']) !!}
				</div>
				{!! Form::close() !!}
			</td>
		</tr>
		<tr>
			<th>Registreerunud</th>
			<td>{{ $user->created_at }}</td>
		</tr>
		<tr>
			<th>Google</th>
			<td>{{ $user->g_id }}</td>
		</tr>
		<tr>
			<th>Facebook</th>
			<td>{{ $user->fb_id }}</td>
		</tr>
	</table>
	{!! Form::open(['method' => 'DELETE', 'url' => 'admin/users/' .$user->id]) !!}
		<button type="submit" class="btn btn-danger btn-mini">Delete</button>
	{!! Form::close() !!}


@stop