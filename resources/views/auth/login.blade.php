@include('errors.list')

<form class="form-horizontal form-modal" role="form" method="POST" action="/authenticate">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="form-group">
		<label class="col-md-4 control-label">E-Mail</label>
		<div class="col-md-6">
			<input type="email" class="form-control" name="email" value="{{ old('email') }}">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">Parool</label>
		<div class="col-md-6">
			<input type="password" class="form-control" name="password">
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="remember"> Jäta meelde
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn btn-primary" style="margin-right: 15px;">
				Logi sisse
			</button>
			<a href="/password/email">Unustasid parooli?</a>
		</div>
	</div>
</form>

<hr>

<a href="/auth/social/facebook" class="btn btn-primary">Facebook</a>
<a href="/auth/social/google" class="btn btn-danger">Google</a>
