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
			<th>Koordinaadid</th>
		</tr>

		@foreach ($trainings as $training)
			<tr>
				<td>{{ $training->title }}</td>
				<td>{{ $training->description }}</td>
				<td>{{ $training->aadress }}</td>
				<td>{{ $training->coordinates }}</td>
			</tr>
		@endforeach

	</table>

@stop