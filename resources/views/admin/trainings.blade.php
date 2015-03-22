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

		<table class="table">
			<tr>
				<th>Nimi</th>
				<th>Kirjeldus</th>
				<th>Aadress</th>
				<th>Kinnitatud</th>
				<th>Omanik</th>
			</tr>
			@foreach ($trainings as $training)
				<tr>
					<td>
						<a href="{{ url('admin/trainings', array($training->id, 'edit') )}}">
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