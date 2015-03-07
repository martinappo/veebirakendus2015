@extends('app')

@section('content')
	@foreach ($trainings as $training)
		<li>{{ $training->title }}</li>
	@endforeach
@stop