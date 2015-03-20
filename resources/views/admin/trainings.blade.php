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

@stop