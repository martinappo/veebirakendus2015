{!! Form::open(['method' => 'POST', 'url' => 'admin/trainings/bulkedit']) !!}

<table class="table">
	<tr>
		<th>Valitud</th>
		<th>
			Nimi
			<a href="trainings/sort" id="trainings.title" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="trainings/sort" id="trainings.title" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			Kirjeldus
			<a href="trainings/sort" id="trainings.description" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="trainings/sort" id="trainings.description" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			Aadress
			<a href="trainings/sort" id="trainings.aadress" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="trainings/sort" id="trainings.aadress" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			Kinnitatud
			<a href="trainings/sort" id="trainings.confirmed" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="trainings/sort" id="trainings.confirmed" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			Omanik
			<a href="trainings/sort" id="owner" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="trainings/sort" id="owner" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
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

{!! Form::close() !!}