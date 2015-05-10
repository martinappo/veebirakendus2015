<h5>Kommentaarid</h5>

@if (count($comments))
	@foreach($comments as $comment)
		<div class="comment clearfix" id="comment-{{ $comment->id }}">
			<div class="col-md-12">
				<span class="glyphicon glyphicon-user"></span>
				{{ $comment->user()->first()->name }}
			</div>
			<div class="col-md-12">
				{{ $comment->content }}
			</div>
			@if (Auth::user())
				@if (Auth::user()->isAdmin())
					<div class="col-md-12">
						<button class="btn btn-xs btn-danger pull-right delete-comment" commentid="{{ $comment->id }}">Kustuta</button>
					</div>
				@endif
			@endif
			<div class="clearfix"></div>
			<hr>
		</div>
	@endforeach
@else
	<div class="col-md-12">
		<small>Kommentaarid puuduvad.</small>
	</div>
@endif