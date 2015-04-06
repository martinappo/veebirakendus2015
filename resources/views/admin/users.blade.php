@extends('app')
@section('content')
	<div class="page-header">
		<h1>Kasutajad</h1>
	</div>

	{!! Form::open(['method' => 'POST', 'url' => 'admin/users/bulkedit']) !!}

	<table class="table">
		<tr>
			<th>Valitud</th>
			<th>Nimi</th>
			<th>E-mail</th>
			<th>Roll</th>
			<th>Treeninguid</th>
			<th>Lugemata teateid</th>
			<th>Blokeeritud</th>
			<th>Blokeeringu lõpp</th>
		</tr>
		@foreach ($users as $user)
			<tr>
				<td>{!! Form::checkbox($user->id, 'selected', false) !!}</td>
				<td>
					<a href="{{ url('admin/users', array($user->id, 'edit') )}}">
						{{ $user->name }}
					</a>
				</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->role }}</td>
				<td>{{ $user->training_count }}</td>
				<td>{{ $user->notifications_count }}</td>
				<td>
					@if ($user->blocked)
						Jah
					@else
						Ei
					@endif
				</td>
				<td>
					@if ($user->blocked)
						{{ $user->blocked_until }}
					@endif
				</td>
				
			</tr>
		@endforeach

	</table>

	<div class="panel-footer">
		<div class="form-group">
			{!! Form::label('action', 'Tegevus') !!}
			{!! Form::select('action', array('delete' => 'Kustuta', 'block' => 'Blokeeri', 'unBlock' => 'Eemalda blokeering'), 'confirm', ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::submit('Kinnita tegevus' , ['class' => 'form-control btn btn-primary']) !!}
		</div>
	</div>

@stop