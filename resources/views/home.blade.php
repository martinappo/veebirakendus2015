@extends('app')

@section('header')
<div class="home-map">
	<div id="map-container" class="container map-container"></div>
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

@section('footer')
	<script src="/js/index.min.js"></script>
@stop
