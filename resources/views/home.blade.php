@extends('app')

@section('header')
<div class="home-map">
	<div class="container map-container"></div>
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
<script async="async">
	/*
	Loading google maps after page load to reduce initial view
	requests.
	 */
	$(window).load(function() {
		var mapIframe = document.createElement('iframe');
		mapIframe.src='https://www.google.com/maps/embed/v1/place?q=%C3%9Clikooli%2C%20Tartu%2C%20Tartu%20linn%2C%20Estonia&key=AIzaSyDkK8oL9mzyASA_lqgYYDleQDjVZLOonOY';
		mapIframe.width='100%'; 
		mapIframe.height=450;
		mapIframe.frameBorder='0';

		$('.map-container').append(mapIframe);
		$('.map-container iframe').css('visibility', 'hidden');

		$(mapIframe).load(function() {
			$('.map-container iframe').css('visibility', 'visible');
		});
	});
</script>
@endsection
