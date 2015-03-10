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
			{!! Form::submit($submitText , ['class' => 'form-control btn btn-primary']) !!}
		</div>