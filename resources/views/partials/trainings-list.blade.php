@if (count($trainings))
	@foreach($trainings as $training)
		<div class="panel panel-default" id="{{ $training->id }}">
			<div class="panel-heading">
				<h3 class="panel-title pull-left">
					{{ $training->title }}
				</h3>
				<div class="pull-right">
					<span class="small">
						Hinne:
					</span>
					<span class="badge">
						{{ $training->getAverageRating() }}
					</span>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				<div class="col-md-3 col-sm-4">
					@if(count($training->files))
						<img src="{{ URL::to('/') }}/{{ array_first($training->files, function(){return true;})->thumbnail_url }}" alt="">
					@else
						<div class="small">Pilt puudub</div>
					@endif
				</div>

				<div class="col-md-9 col-sm-8">
					<p><b>Aadress:</b> {{ $training->aadress }}</p>
					<p><b>Kirjeldus:</b> {{ $training->description }}</p>
					<p><b>Postitaja:</b> {{ $training->user->name }}</p>
					<div class="row">
						<div class="col-md-6">
							@foreach ($training->tags as $tag)
								<div class="badge">
									{{ $tag->name }}
								</div>
							@endforeach
						</div>
						<div class="col-md-6">
							<div class="pull-right" id="rate-{{ $training->id }}">
								@include('partials.trainings-rate')
							</div>
						</div>
					</div>
				</div>
				<!-- comments -->
				<div class="clearfix"></div>
				<hr>
				<a class="btn btn-default btn-xs" data-toggle="collapse" href="#comments-{{ $training->id }}" aria-expanded="false" aria-controls="comments-{{ $training->id }}">
					Kommentaarid
				</a>
				<div class="comments-container row collapse" id="comments-{{ $training->id }}">
					@if(!Auth::Guest())

						<div class="col-md-4">
							<h5>Lisa kommentaar</h5>
							<textarea name="content" id="comment-{{ $training->id }}" class="form-control"></textarea>
							<br>
							<button class="btn btn-default add-comment" training="{{ $training->id }}">Lisa</button>
						</div>

						<div class="col-md-8 comments" >
							@include('partials.comments', ['comments' => $training->comments()->get()])
						</div>

					@else
						@include('partials.comments', ['comments' => $training->comments()->get()])
					@endif
				</div>

			</div>
		</div>
	@endforeach
@else
	<div class="alert alert-warning">
		Sellisele otsingule vasted puuduvad.
	</div>
@endif