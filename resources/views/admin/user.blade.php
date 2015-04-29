@extends('app')

@section('content')
	<div class="page-header">
		<h1>{{$user->name}}</h1>
		{!! Form::open(['method' => 'DELETE', 'url' => 'admin/users/' .$user->id]) !!}
			<div class="btn-group" role="group">
				<button type="submit" class="btn btn-danger btn-xs">Kustuta kasutaja</button>
				<a href="{{ URL::previous() }}" class="btn btn-default btn-xs">Tagasi</a>
			</div>
		{!! Form::close() !!}
	</div>

	{!! Form::open(['method' => 'PATCH', 'url' => 'admin/users/' .$user->id]) !!}

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
					@if ($user->role == 'user')
						Kasutaja
					@elseif ($user->role == 'admin')
						Administraator
					@else
						Tundmatu
					@endif
					{!! Form::select('role', array('user'=>'Kasutaja','admin'=>'Administraator'), $user->role, ['class' => 'form-control']) !!}
				</td>
			</tr>
			@if ($user->role == 'user')
				<tr>
					<th>Blokeeritud</th>
					<td>
						@if ($user->blocked)
							Jah
						@else
							Ei
						@endif
						{!! Form::select('blocked', array(0=>'Ei', 1=>'Jah'), $user->blocked, ['class' => 'form-control']) !!}
					</td>
				</tr>
				<tr>
					<th>Blokeeringu lõpp</th>
					<td>
						@if ($user->blocked)
							{{ $user->blocked_until }}
						@endif
						{!! Form::input('datetime-local', 'blocked_until', null, ['class' => 'form-control']) !!}
					</td>
				</tr>
				<tr>
					<th>Blokeeringu põhjus</th>
					<td>
						@if ($user->blocked)
							{{ $user->block_reason }}
						@endif
						{!! Form::text('block_reason', null, ['class' => 'form-control']) !!}
					</td>
				</tr>
			@endif
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
		{!! Form::submit('Kinnita muudatused' , ['class' => 'btn btn-primary']) !!}

	{!! Form::close() !!}

@stop