@extends('app')

@section('content')
<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">Kasutajad</div>

		<div class="panel-body">
			Kasutajaid kokku: {{ $userCount }}<br>
			Uusimad kasutajad:<br>
			@foreach ($users as $user)
				<li>
					<a href="{{ url('admin/users', array($user->id, 'edit') )}}">
						{{ $user->name }}
					</a>
				</li>
			@endforeach
		</div>
		<div class="panel-footer">
			<a href="{{ url('admin/users') }}" class="btn btn-default">Kõik kasutajad</a>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">Treeningud</div>

		<div class="panel-body">
			Trenne kokku: {{ $trainingCount }}<br>
			Kinnitamata trenne: {{ $trainings->count() }}<br>
			@foreach ($trainings as $training)
				<li>
					<a href="{{ url('trainings', array($training->id, 'edit') )}}">
						{{ $training->title }}
					</a>
				</li>
			@endforeach
		</div>

		<div class="panel-footer">
			<a href="{{ url('admin/trainings') }}" class="btn btn-default">Kõik treeningud</a>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">Teavitused</div>

		<div class="panel-body">
			@if ($notifications->count())
				@foreach ($notifications as $notification)
						<h4>{{ $notification->title }}</h4>
						<p>{{ $notification->content }}</p>
						<div class="clearfix">
							<small class="pull-right">{{ date("d.m.Y, h:i", strtotime($notification->updated_at)) }}</small>
						</div>
						<hr>
				@endforeach

			@else
				<div class="col-md-12">
					<hr>
					<p>Teavitused puuduvad.</p>
					<hr>
				</div>
			@endif
		</div>
	</div>
</div>
@endsection
