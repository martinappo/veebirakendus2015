@if ($notifications->count())

	@foreach ($notifications as $notification)
		<div class="notification col-md-12" id="notification-{{ $notification->id }}">
			<h4>{{ $notification->title }}</h4>
			<p>{{ $notification->content }}</p>
			<div class="clearfix">
				<small class="pull-right">{{ date("d.m.Y, h:i", strtotime($notification->updated_at)) }}</small>
				{!! Form::open(['method' => 'DELETE', 'url' => '/notification/{{ $notification->id }}']) !!}
					<button type="submit" href="/notification/{{ $notification->id }}" notificationId="{{ $notification->id }}" class="btn btn-xs remove-notification pull-left">Eemalda</button>
				{!! Form::close() !!}
			</div>
			<hr>
		</div>
	@endforeach

@else

	<div class="col-md-12">
		<hr>
		<p>Teavitused puuduvad.</p>
		<hr>
	</div>

@endif

