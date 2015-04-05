@extends('app')

@section('content')
<div class="page-header">
	<h1><span class="glyphicon glyphicon-user"></span> Profiil</h1>
</div>
<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">Pilt</div>

		<div class="panel-body">
			
		</div>
	</div>
</div>

<div class="col-md-8">
	<div class="panel panel-default">
		<div class="panel-heading">Andmed</div>

		<div class="panel-body">
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
					<th>Facebook</th>
					<td>
						@if ($user->fb_id)
							<span class="glyphicon glyphicon-ok"></span>
							Seotud facebookiga.
							{!! Form::open(['method' => 'DELETE', 'url' => '/auth/social/facebook']) !!}
								<button type="submit" class="btn btn-danger btn-mini">Seo lahti</button>
							{!! Form::close() !!}
						@else
							<a class="btn btn-default" href="/auth/social/facebook">Seo kasutaja</a>
						@endif
					</td>
				</tr>
				<tr>
					<th>Google</th>
					<td>
						@if ($user->g_id)
							<span class="glyphicon glyphicon-ok"></span>
							Seotud googlega
							{!! Form::open(['method' => 'DELETE', 'url' => 'auth/social/google']) !!}
								<button type="submit" class="btn btn-danger btn-mini">Seo lahti</button>
							{!! Form::close() !!}
						@else
							<a class="btn btn-default" href="/auth/social/google">Seo kasutaja</a>
						@endif
					</td>
				</tr>
			</table>
		</div>

		<div class="panel-footer">
			{!! Form::open(['method' => 'DELETE', 'url' => 'profile']) !!}
				<button type="submit" class="btn btn-danger btn-mini">Kustuta oma kasutaja</button>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title pull-left">Lisatud treeningud</h3>
			<a href="{{ url('trainings/create' )}}" class="btn btn-default pull-right">Lisa treening</a>
			<div class="clearfix"></div>
		</div>
			@foreach($trainings as $training)
			<div class="panel-body">
				<div class="panel panel-default">
					<table class="table">
						<thead>
							<tr>
								<th>{{ $training->title }}</th>
								<th>
									{!! Form::open(['method' => 'DELETE', 'url' => url('trainings', array($training->id) )]) !!}
										<div class="btn-group pull-right" role="group" aria-label="...">
											<a href="{{ url('trainings', array($training->id, 'edit') )}}" class="btn btn-default">Muuda</a>
											<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
										</div>
									{!! Form::close() !!}
								</th>
							</tr>
						</thead>
						<tr>
							<th>Aadress</th>
							<td>{{ $training->aadress }}</td>
						</tr>
						<tr>
							<th>Märksõnad</th>
							<td>
								@foreach ($training->tags as $tag)
									<div class="badge">
										{{ $tag->name }}
									</div>
								@endforeach
							</td>
						</tr>
						<tr>
							<th>Kinnitatud</th>
							<td>
								@if ($training->confirmed)
									<span class="glyphicon glyphicon-ok"></span>
								@else
									<span class="glyphicon glyphicon-remove"></span>
								@endif
							</td>
						</tr>
					</table>
				</div>
			</div>
			@endforeach
	</div>
</div>

@endsection
