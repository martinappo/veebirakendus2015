@extends('app')

@section('content')
	<div class="page-header">
		<h1>Muuda treeningut {!! $training->title !!}</h1>
	</div>

	{!! Form::model($training, ['method' => 'PATCH', 'url' => 'trainings/' .$training->id]) !!}
		@include('partials.trainings-form', ['submitText' => 'Muuda'])
	{!! Form::close() !!}
	@include('partials.form-upload')

	@include('errors.list')

@stop