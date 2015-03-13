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
			<script>
				$('#tag_list').select2({
					placeholder: 'Vali märksõnad',
					tags: true,
				});
			</script>
		@endsection