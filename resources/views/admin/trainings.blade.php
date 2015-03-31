@extends('app')

@section('content')
	<div class="page-header">
		<h1>Treeningud</h1>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				Treeningud
			</h3>
		</div><!-- panel heading -->

		{!! Form::open(['method' => 'POST', 'url' => 'admin/trainings/bulkedit']) !!}

		<table class="table">
			<tr>
				<th>Valitud</th>
				<th>Nimi</th>
				<th>Kirjeldus</th>
				<th>Aadress</th>
				<th>Kinnitatud</th>
				<th>Omanik</th>
			</tr>
			@foreach ($trainings as $training)
				<tr>
					<td>{!! Form::checkbox($training->id, 'selected', false) !!}</td>
					<td>
						<a href="{{ url('trainings', array($training->id, 'edit') )}}">
							{{ $training->title }}
						</a>
					</td>
					<td>{{ $training->description }}</td>
					<td>{{ $training->aadress }}</td>
					<td>
						@if ($training->confirmed)
							Jah
						@else
							Ei
						@endif
					</td>
					<td>
						{{ $training->owner }}
					</td>
				</tr>
			@endforeach
		</table>

		<div class="panel-footer">
			<div class="form-group">
				{!! Form::label('action', 'Tegevus') !!}
				{!! Form::select('action', array('delete' => 'Kustuta', 'confirm' => 'Kinnita', 'removeConfirmation' => 'Eemalda kinnitus'), 'confirm', ['class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::submit('Kinnita tegevus' , ['class' => 'form-control btn btn-primary']) !!}
			</div>
		</div>

		{!! Form::close() !!}

	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				Tagid
			</h3>
		</div><!-- panel heading -->

		<table class="table">
			<tr>
				<th>Nimetus</th>
				<th>Treeninguid seotud</th>
				<th>Eemalda</th>
			</tr>
			@foreach ($tags as $tag)
				<tr>
					<td>{{ $tag->name }}</td>
					<td>{{ $tag->trainings->count() }}</td>
					<td>
						{!! Form::open(['method' => 'DELETE', 'url' => 'admin/tags/'.$tag->id ]) !!}
							<button type="submit" class="btn btn-danger btn-xs">Kustuta</button>
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
		</table>
	</div>


@stop