@extends('app')

@section('header')
<div class="home-map">
	<div id="map-container" class="container map-container"></div>
</div>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">Avaleht</div>

				<div class="panel-body">
					<p>
						Sa oled jõudnud kodulehele, kust leiad endale koha treenimiseks. 
					</p>
					<p>
						Otsingusüsteem on imelihtne. Valides kaardil asukoha ning raadiuse, mille piires treeningukohti soovite näha, kuvatakse teile just soovitud kohad. Oma otsingutulemusi on võimalik kitsendada ka märksõnade järgi.
					</p>
				</div>

			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">Lisa treeninguid</div>

				<div class="panel-body">
					<p>
						Sul on võimalus ka aidata teistel inimestel leida endale treeningkoht, neid soovitades. Uue koha lisamine on võimalik vaid sisse logides. Tuleb täita vorm ning seejärel jääda ootama administraatori kinnitust.
					</p>
				</div>

			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">Avalda arvamust</div>

				<div class="panel-body">
					<p>
						Kas mõni treeningukoht on eriti äge? Jaga oma rõõmu ka teistega, andes kohale hea hinne või seda kommenteerides.
					</p>
				</div>

			</div>
		</div>
	</div>
	<a class="btn btn-primary pull-right" href="/trainings">Alusta siit</a>
</div>
@endsection

@section('footer')
	<script src="/js/index.min.js"></script>
@stop
