@extends('app')

@section('content')
	@foreach ($trainings as $training)
		<li>{{ $training }}</li>
	@endforeach
@stop