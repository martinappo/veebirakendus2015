		@if (Auth::user()->isAdmin())
			<div class="input-group col-md-3">
				<span class="input-group-addon">
					{!! Form::hidden('confirmed', 0) !!}
					{!! Form::checkbox('confirmed', true, ['class' => 'form-control']) !!}
				</span>
				<span class="form-control">
					{!! Form::label('confirmed', 'Kinnitatud') !!}
				</span>
			</div>
		@endif

		<div class="form-group">
			{!! Form::label('title', 'Nimi') !!}
			{!! Form::text('title', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('aadress', 'Aadress') !!}
			{!! Form::text('aadress', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('description', 'Kirjeldus') !!}
			{!! Form::textarea('description', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('tag_list', 'Märksõnad') !!}
			{!! Form::select('tag_list[]', $tags, null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
		</div>

		<div class="form-group">
			{!! Form::submit($submitText , ['class' => 'form-control btn btn-primary']) !!}
		</div>

		@section('footer')
			<script src="/js/forms.min.js"></script>
			<script>
				//Tags
				$('#tag_list').select2({
					placeholder: 'Vali märksõnad',
					tags: true,
				});
				//Fileupload
				$(function () {
					$('#fileupload').fileupload({
						url: 'upload',
						dataType: 'json',

						done: function (e, data) {
							$.each(data.files, function (index, file) {
								 $('<p/>').text(file.name).appendTo('#files');
							});
						},
						progressall: function (e, data) {
							var progress = parseInt(data.loaded / data.total * 100, 10);
							$('#progress .progress-bar').css(
								 'width',
								 progress + '%'
							);
						}
					}).prop('disabled', !$.support.fileInput)
						.parent().addClass($.support.fileInput ? undefined : 'disabled');
				});
			</script>
		@endsection