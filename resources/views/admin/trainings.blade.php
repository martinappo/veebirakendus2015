@extends('app')

@section('content')
	<div class="page-header">
		<h1>Treeningud</h1>
	</div>

	<table class="table">
		<tr>
			<th>Nimi</th>
			<th>Kirjeldus</th>
			<th>Aadress</th>
			<th>Kinnitatud</th>
			<th>Märksõnad</th>
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
					@foreach ($training->tags as $tag)
						{{ $tag->name . ' '}}
					@endforeach
				</td>
			</tr>
		@endforeach

	</table>

@stop