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
		@endsection