@extends('app')
@section('content')
	<div class="page-header">
		<h1>Kasutajad</h1>
	</div>
	<div id="users-list">
		@include("partials.users-list")
	</div>

	<div class="panel-footer">
		<div class="form-group">
			{!! Form::label('action', 'Tegevus') !!}
			{!! Form::select('action', array('delete' => 'Kustuta', 'block' => 'Blokeeri', 'unBlock' => 'Eemalda blokeering'), 'confirm', ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::submit('Kinnita tegevus' , ['class' => 'form-control btn btn-primary']) !!}
		</div>
	</div>

@stop

@section('footer')
	<script src="/js/sort.users.js"></script>
@stop