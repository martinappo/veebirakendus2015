<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">LeiaTrenn</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="/">Kodu</a></li>
				<li><a href="/trainings">LeiaTrenn</a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				@if (Auth::guest())
					<li><a href="/auth/login" class="open-in-modal" title="Logi sisse">Logi sisse</a></li>
					<li><a href="/auth/register">Registreeri</a></li>
				@else
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							Teavitused<span class="caret"></span>
						</a>
						<div id="notifications" class="dropdown-menu" role="menu">
							@include('partials.notifications')
						</div>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/auth/logout">Logi välja</a></li>
							<li><a href="/profile">Profiil</a></li>
							@if (Auth::user()->isAdmin())
							<li><a href="/admin">Admin</a></li>
							@endif
						</ul>
					</li>
				@endif
			</ul>
		</div>
	</div>
</nav>