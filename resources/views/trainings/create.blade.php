@extends('app')

@section('content')
	<div class="page-header">
		<h1>Lisa uus treening</h1>
	</div>
	@include('errors.list')
	{!! Form::model($training = new \App\Training, ['url' => 'trainings']) !!}
		@include('partials.trainings-form', ['submitText' => 'Lisa'])
	{!! Form::close() !!}
@stop