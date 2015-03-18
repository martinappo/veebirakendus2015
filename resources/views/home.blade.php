@extends('app')

@section('header')
<div class="home-map">
	<div class="container map-container">
		<iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=%C3%9Clikooli%2C%20Tartu%2C%20Tartu%20linn%2C%20Estonia&key=AIzaSyDkK8oL9mzyASA_lqgYYDleQDjVZLOonOY"></iframe>
	</div>
</div>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Avaleht</div>

				<div class="panel-body">
					Sa oled jõudnud kodulehele, kust leiad endale koha treenimiseks.
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
