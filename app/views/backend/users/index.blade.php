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

<a class="btn btn-medium" href="{{ URL::to('admin/users?withTrashed=true') }}">Include Deleted Users</a>
<a class="btn btn-medium" href="{{ URL::to('admin/users?onlyTrashed=true') }}">Include Only Deleted Users</a>
<br><br>

@if (count($users) > 10)
{{ $users->links() }}
@endif

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span1">@lang('admin/users/table.id')</th>
			<th class="span2">@lang('admin/users/table.first_name')</th>
			<th class="span2">@lang('admin/users/table.last_name')</th>
			<th class="span3">@lang('admin/users/table.email')</th>
			<th class="span1">@lang('admin/users/table.checkedout')</th>
			<th class="span1">@lang('admin/users/table.activated')</th>
			<th class="span2">@lang('admin/users/table.last_login')</th>
			<th class="span2">@lang('admin/users/table.created_at')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $user)
		<tr>
			<td>{{ $user->id }}</td>
			<td>{{ $user->first_name }}</td>
			<td>{{ $user->last_name }}</td>
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
				<a href="{{ route('restore/user', $user->id) }}" class="btn btn-mini btn-warning"><i class="icon-share-alt icon-white"></i> @lang('button.restore')</a>
				@else
				<a href="{{ route('update/user', $user->id) }}" class="btn btn-mini"><i class="icon-pencil"></i> @lang('button.edit')</a>
				@if (Sentry::getId() !== $user->id)
				<a href="{{ route('delete/user', $user->id) }}" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> @lang('button.delete')</a>
				@else
				<span class="btn btn-mini btn-danger disabled"><i class="icon-remove icon-white"></i> @lang('button.delete')</span>
				@endif
				@endif
			@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@if (count($users) > 10)
{{ $users->links() }}
@endif

@stop
