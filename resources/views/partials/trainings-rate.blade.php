@if ( ! Auth::guest())
	<span class="small">Hinda:</span>
	{!! Form::open(['method' => 'POST', 'url' => 'rate/{{ $training->id }}']) !!}
		<?php $userRate = $training->ratings()->where('user_id', '=', Auth::user()->id)->first()['value'] ?>
		<span class="rate badge {{ ($userRate == 1) ? 'active' : '' }}" id="{{ $training->id }}">1</span>
		<span class="rate badge {{ ($userRate == 2) ? 'active' : '' }}" id="{{ $training->id }}">2</span>
		<span class="rate badge {{ ($userRate == 3) ? 'active' : '' }}" id="{{ $training->id }}">3</span>
		<span class="rate badge {{ ($userRate == 4) ? 'active' : '' }}" id="{{ $training->id }}">4</span>
		<span class="rate badge {{ ($userRate == 5) ? 'active' : '' }}" id="{{ $training->id }}">5</span>
	{!! Form::close() !!}
@endif