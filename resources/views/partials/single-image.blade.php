<div class="col-sm-6 edit-training-image-container" id="file-{{ $file->id }}">
	<img src="{{ URL::to('/') }}/{{ $file->thumbnail_url }}" alt="">
	<hr>
	<div class="row">
		<span class="small">{{ $file->name }}</span>
		<button class="btn btn-xs delete-file" id="{{ $file->id }}" href="{{ url('trainings/file', array($file->id) )}}">
			<span class="glyphicon glyphicon-trash"></span>
		</button>
	</div>
</div>