@extends('app')

@section('content')
	<div class="page-header">
		<h1>Lisa uus treening</h1>
	</div>

	{!! Form::open(['url' => 'trainings']) !!}
		@include('partials.trainings-form', ['submitText' => 'Lisa'])
	{!! Form::close() !!}

	@include('errors.list')

@stop