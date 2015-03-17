@if ($errors->any())
	@foreach ($errors->all() as $error)
		<li>
			{{ $error }}
		</li>
	@endforeach
@endif
<div id="ajaxError" class="alert alert-danger" style="display:none"></div>