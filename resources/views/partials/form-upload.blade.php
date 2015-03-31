{!! Form::open( ['method' => 'POST', 'url' => 'trainings/' .$training->id. '/upload', 'files' => 'true']) !!}
<input id="fileupload" type="file" name="file">
{!! Form::close() !!}
<!-- The global progress bar -->
<div id="progress" class="progress">
	<div class="progress-bar progress-bar-success"></div>
</div>
<!-- The container for the uploaded files -->
<div id="files" class="files"></div>
<br>

