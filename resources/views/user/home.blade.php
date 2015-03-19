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
						@else
							<a class="btn btn-default" href="/auth/social/facebook">Seo kasutaja</a>
						@endif
					</td>
				</tr>
				<tr>
					<th>Google</th>
					<td>
						@if ($user->g_id)
							Seotud googlega
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

@endsection
