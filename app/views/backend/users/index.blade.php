@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
User Management ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">

	<div class="pull-right">
	@if (Input::get('onlyTrashed'))
		<a class="btn-flat white" href="{{ URL::to('admin/users') }}">Show Current Users</a>
	@else
		<a class="btn-flat white" href="{{ URL::to('admin/users?onlyTrashed=true') }}">Show Deleted Users</a>
	@endif

		<a href="{{ route('create/user') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i> New User</a>
	</div>

	<h3>
		@if (Input::get('onlyTrashed'))
			Deleted
		@else
			Current
		@endif

		 Users
	</h3>
</div>




<br><br>

@if ($users->getTotal() > 10)
{{ $users->links() }}
@endif

@if ($users->getTotal() > 0)
<div class="row-fluid table users-list">
<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-3">@lang('admin/users/table.name')</th>
			<th class="col-md-2">@lang('admin/users/table.email')</th>
			<th class="col-md-1">Assets</th>
			<th class="col-md-1">Licenses</th>
			<th class="col-md-1">@lang('admin/users/table.activated')</th>
			<th class="col-md-3">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>

		@foreach ($users as $user)
		<tr>
			<td>
			<img src="{{ $user->gravatar() }}" class="img-circle avatar hidden-phone" style="max-width: 45px;" />
			<a href="{{ route('view/user', $user->id) }}" class="name">{{ $user->fullName() }}</a>

			</td>
			<td>{{ $user->email }}</td>
			<td>{{ $user->assets->count() }}</td>
			<td>{{ $user->licenses->count() }}</td>
			<td>{{ $user->isActivated() ? '<i class="icon-ok"></i>' : ''}}</td>
			<td>
			@if ($user->id > 3)
				@if ( ! is_null($user->deleted_at))
				<a href="{{ route('restore/user', $user->id) }}" class="btn-flat default"><i class="icon-share-alt icon-white"></i> @lang('button.restore')</a>
				@else
				<a href="{{ route('update/user', $user->id) }}" class="btn-flat white"><i class="icon-pencil"></i> @lang('button.edit')</a>
				@if (Sentry::getId() !== $user->id)
				<a  data-html="false" class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/user', $user->id) }}" data-content="Are you sure you wish to delete this user?" data-title="Delete {{ htmlspecialchars($user->first_name) }}?" onClick="return false;"><i class="icon-remove icon-white"></i> @lang('button.delete')</a>

				@else
				<span class="btn-flat danger disabled"><i class="icon-remove icon-white"></i> @lang('button.delete')</span>
				@endif
				@endif
			@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
@else
<div class="col-md-6">
	<div class="alert alert-warning alert-block">
		<i class="icon-warning-sign"></i>
		@lang('admin/users/table.noresults')

	</div>
</div>
@endif

@if ($users->getTotal() > 10)
{{ $users->links() }}
@endif

@stop
