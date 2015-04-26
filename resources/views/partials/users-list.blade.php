{!! Form::open(['method' => 'POST', 'url' => 'admin/users/bulkedit']) !!}

<table class="table">
	<tr>
		<th>Valitud</th>
		<th>
			Nimi
			<a href="users/sort" id="users.name" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="users/sort" id="users.name" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			E-mail
			<a href="users/sort" id="users.email" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="users/sort" id="users.email" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			Roll
			<a href="users/sort" id="users.role" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="users/sort" id="users.role" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			Treeninguid
			<a href="users/sort" id="training_count" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="users/sort" id="training_count" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			Lugemata teateid
			<a href="users/sort" id="notifications_count" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="users/sort" id="notifications_count" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			Blokeeritud
			<a href="users/sort" id="users.blocked" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="users/sort" id="users.blocked" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			Blokeeringu lõpp
			<a href="users/sort" id="users.blocked_until" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="users/sort" id="users.blocked_until" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
		<th>
			Blokeeringu põhjus
			<a href="users/sort" id="users.block_reason" dir="ASC" class="btn btn-default btn-xs sort">&uarr;</a>
			<a href="users/sort" id="users.block_reason" dir="DESC" class="btn btn-default btn-xs sort">&darr;</a>
		</th>
	</tr>
	@foreach ($users as $user)
		<tr>
			<td>{!! Form::checkbox($user->id, 'selected', false) !!}</td>
			<td>
				<a href="{{ url('admin/users', array($user->id, 'edit') )}}">
					{{ $user->name }}
				</a>
			</td>
			<td>{{ $user->email }}</td>
			<td>
				@if ($user->role == 'user')
					Kasutaja
				@elseif ($user->role == 'admin')
					Administraator
				@else
					Tundmatu
				@endif
			</td>
			<td>{{ $user->training_count }}</td>
			<td>{{ $user->notifications_count }}</td>
			<td>
				@if ($user->blocked)
					Jah
				@else
					Ei
				@endif
			</td>
			<td>
				@if ($user->blocked)
					{{ $user->blocked_until }}
				@endif
			</td>
			<td>
				@if ($user->blocked)
					{{ $user->block_reason }}
				@endif
			</td>
			
		</tr>
	@endforeach
	
</table>

{!! Form::close() !!}