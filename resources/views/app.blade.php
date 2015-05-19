<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Leiatrenn</title>
	<!-- css -->
	<link href="/css/all.css" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<header id="mainHeader" class="container-fluid">
		<div class="row">
			@include('partials.navbar')
			<div class="container">
				@include('partials.flash-message')
			</div>
			@yield('header')
		</div>
	</header>

	<div class="container" id="mainContainer">
		@yield('content')
	</div>
	<script src="/js/main.min.js"></script>
	@if (!Auth::guest())
		<script>
			window.setInterval(function(){
				jQuery.ajax({
					type:'GET',
					url: '/notifications',
					data: {
						updated: $('#notificat').val(),
					},
					success: function(data) {
						$('#notifications').html(data);
					},
					error: function(data) {
						console.log(data.responseJSON);
					}
				});
			}, 10000);
		</script>
	@endif

	<footer class="container-fluid" id="mainfooter">
		<div class="row">
			<div class="container">
				<div class="col-md-4">
					<h1 class="logo">LeiaTrenn</h1>
				</div>
				<div class="col-md-4">
					See on arendusfaasis kooliprojekt. Kui tekib küsimusi või soovitusi võtke ühendust <a href="mailto:martinappo@gmail.com">martinappo@gmail.com</a>
				</div>
				<div class="col-md-4">
					<ul id="footermenu">
						@if (Auth::guest())
							<li><a href="/auth/login" class="open-in-modal" title="Logi sisse">Logi sisse</a></li>
							<li><a href="/auth/register">Registreeri</a></li>
						@else
							<li><a href="/auth/logout">Logi välja</a></li>
							<li><a href="/profile">Profiil</a></li>
							@if (Auth::user()->isAdmin())
							<li><a href="/admin">Admin</a></li>
							@endif
						@endif
					</ul>
				</div>
				
			</div>
		</div>
	</footer>
	@yield('footer')
</body>
</html>
