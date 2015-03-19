@extends('app')

@section('content')
<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">Kasutajad</div>

		<div class="panel-body">
			@foreach ($users as $user)
				<li>
					{{ $user->name }}
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
			<small>Kinnitamata</small>
			@foreach ($trainings as $training)
				<li>
					<a href="{{ url('admin/trainings', array($training->id, 'edit') )}}">
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
		<div class="panel-heading">Kommentaarid</div>

		<div class="panel-body">
			
		</div>
	</div>
</div>
@endsection
