@extends('app')

@section('content')
	<div class="page-header">
		<h1>Lisa uus treening</h1>
	</div>

	{!! Form::open(['url' => 'trainings']) !!}
		<div class="form-group">
			{!! Form::label('title', 'Nimi') !!}
			{!! Form::text('title', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('aadress', 'Aadress') !!}
			{!! Form::text('aadress', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('description', 'Kirjeldus') !!}
			{!! Form::textarea('description', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Lisa treening', null, ['class' => 'btn btn-primary form-control']) !!}
		</div>
	{!! Form::close() !!}
	
	@if ($errors->any())
		@foreach ($errors->all() as $error)
			<li>
				{{ $error }}
			</li>
		@endforeach
	@endif
@stop