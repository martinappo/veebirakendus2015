{!! Form::open(['method' => 'PUT', 'url' => 'trainings/'.$training->id.'/upload']) !!}
	<input id="fileupload" type="file" name="file" multiple="multiple">
{!! Form::close() !!}

<br>

<p class="small">
	Lisatud pildid:
</p>
<div id="files" class="well files">
	<br>
	@foreach ($training->files as $image)
		@include('partials.single-image', ['file' => $image])
	@endforeach
	<span class="clearfix"></span>

</div>

<div id="fileErrors" class="alert alert-warning" style="display:none">
	<p id="fileErrorMessage"></p>
</div>