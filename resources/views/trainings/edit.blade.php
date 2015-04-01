@extends('app')

@section('content')
	<div class="page-header">
		<h1>Muuda treeningut {!! $training->title !!}</h1>
	</div>

		<div class="col-sm-6">
			{!! Form::model($training, ['method' => 'PATCH', 'url' => 'trainings/' .$training->id]) !!}
				@include('partials.trainings-form', ['submitText' => 'Muuda'])
			{!! Form::close() !!}
		</div>
		<div class="col-sm-6">
			@include('partials.form-upload')
		</div>
	@include('errors.list')

@stop