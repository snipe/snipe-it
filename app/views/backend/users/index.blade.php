@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
User Management ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		User Management

		<div class="pull-right">
			<a href="{{ route('create/user') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i> Create New</a>
		</div>
	</h3>
</div>

<a class="btn-flat white" href="{{ URL::to('admin/users?withTrashed=true') }}">Include Deleted Users</a>
<a class="btn-flat white" href="{{ URL::to('admin/users?onlyTrashed=true') }}">Include Only Deleted Users</a>
<br><br>

@if ($users->getTotal() > 10)
{{ $users->links() }}
@endif

@if ($users->getTotal() > 0)
<div class="row-fluid table users-list">
<table id="example">
	<thead>
		<tr role="row">
			<th class="span3">@lang('admin/users/table.name')</th>
			<th class="span2">@lang('admin/users/table.email')</th>
			<th class="span1">@lang('admin/users/table.checkedout')</th>
			<th class="span1">@lang('admin/users/table.activated')</th>
			<th class="span2">@lang('admin/users/table.last_login')</th>
			<th class="span1">@lang('admin/users/table.created_at')</th>
			<th class="span2">@lang('table.actions')</th>
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
			<td>
			{{ ($user->assets->count()) }}
			</td>

			<td>{{ $user->isActivated() ? '<i class="icon-ok"></i>' : ''}}</td>
			<td>
			@if (is_object($user->last_login))
				{{ $user->last_login->diffForHumans() }}
			@else
				Never
			@endif
			</td>
			<td>{{ $user->created_at->diffForHumans() }}</td>

			<td>
			@if ($user->id > 3)
				@if ( ! is_null($user->deleted_at))
				<a href="{{ route('restore/user', $user->id) }}" class="btn-flat default"><i class="icon-share-alt icon-white"></i> @lang('button.restore')</a>
				@else
				<a href="{{ route('update/user', $user->id) }}" class="btn-flat white"><i class="icon-pencil"></i> @lang('button.edit')</a>
				@if (Sentry::getId() !== $user->id)
				<a class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/user', $user->id) }}" data-content="Are you sure you wish to delete the user {{ $user->fullName() }}?" data-title="Delete {{ $user->first_name }}?" onClick="return false;"><i class="icon-remove icon-white"></i> @lang('button.delete')</a>

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
