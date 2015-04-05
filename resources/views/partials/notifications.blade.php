@foreach (Auth::user()->notifications()->get() as $notification)
	<div class="notification col-md-12">
		<h4>{{ $notification->title }}</h4>
		<p>{{ $notification->content }}</p>
		<hr>
	</div>
@endforeach

