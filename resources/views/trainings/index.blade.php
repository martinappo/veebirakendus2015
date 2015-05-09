@extends('app')

@section('content')
	<div class="page-header">
		<h1>Treeningud</h1>
	</div>

	<div class="col-md-12">
		<div id="map-container-search" class="map-container"></div>
	</div>
	<div class="clearfix"></div>
	<hr>
	{!! Form::open(['method' => 'GET', 'url' => 'trainings/search', 'id' => 'search-form']) !!}
	<div class="col-md-6">
		<div class="form-group col-md-12">
			{!! Form::label('tag_list', 'Otsi märksõna järgi') !!}
			{!! Form::select('tag_list[]', $tags, null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
			<div class="small">
				Otsitakse treeningukoha nime, kirjelduse ja märksõnade hulgast.
			</div>
		</div>
		<div class="form-group col-md-6">
			{!! Form::label('what', 'Sorteeri') !!}
			{!! Form::select('what', array('trainings.title' => 'Pealkirja järgi', 'trainings.aadress' => 'Aadressi järgi', 'none' => 'Otsingu täpsuse järgi'), 'none', ['class' => 'form-control']) !!}
			<div class="small">
				Vali mille järgi.
			</div>
		</div>
		<div class="form-group col-md-6">
			{!! Form::label('direction', 'Kasvav/kahanev') !!}
			{!! Form::select('direction', array('asc' => 'Kasvavalt', 'desc' => 'Kahanevalt'), null, ['class' => 'form-control']) !!}
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group col-md-12">
			{!! Form::hidden('longitude', null, ['id' => 'longitude']) !!}
			{!! Form::hidden('latitude', null, ['id' => 'latitude']) !!}
			{!! Form::label('radius', 'Raadius') !!}
			{!! Form::input('number', 'radius', 400,  ['class' => 'form-control', 'id' => 'radius']) !!}
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group pull-right">
			{!! Form::submit('Otsi' , ['class' => 'btn btn-primary', 'id' => 'search-trainings']) !!}
		</div>
	</div>
	{!! Form::close() !!}

	<div class="col-md-12">
		<div class="clearfix"></div>
		<hr>
		<h3>Leitud treeningud</h3>
		<hr>
		<div id="search-results">
			@include('partials.trainings-list')
		</div>
	</div>

@stop