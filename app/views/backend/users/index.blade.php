@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/users/table.title') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/user') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.create')</a>
    	@if (Input::get('onlyTrashed'))
			<a class="btn btn-default pull-right" href="{{ URL::to('admin/users') }}">Show Current Users</a>
		@else
			<a class="btn btn-default pull-right" href="{{ URL::to('admin/users?onlyTrashed=true') }}">Show Deleted Users</a>
		@endif

		<h3>
		@if (Input::get('onlyTrashed'))
			@lang('general.deleted')
		@else
			@lang('general.current')
		@endif

	</h3>
	</div>
</div>

<div class="row form-wrapper">

@if ($users->getTotal() > 0)
<div class="row-fluid table users-list">
<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-3">@lang('admin/users/table.name')</th>
			<th class="col-md-2">@lang('admin/users/table.email')</th>
			<th class="col-md-2">@lang('admin/users/table.manager')</th>
			<th class="col-md-1">@lang('general.assets')</th>
			<th class="col-md-1">@lang('general.licenses')</th>
			<th class="col-md-1">@lang('admin/users/table.activated')</th>
			<th class="col-md-2 actions">@lang('table.actions')</th>
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
			@if ($user->manager)
				{{ $user->manager->fullName() }}
			@endif
			</td>
			<td>{{ $user->assets->count() }}</td>
			<td>{{ $user->licenses->count() }}</td>
			<td>{{ $user->isActivated() ? '<i class="icon-ok"></i>' : ''}}</td>
			<td>

				@if ( ! is_null($user->deleted_at))
				<a href="{{ route('restore/user', $user->id) }}" class="btn btn-warning"><i class="icon-share-alt icon-white"></i></a>
				@else
				<a href="{{ route('update/user', $user->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>

				@if (Sentry::getId() !== $user->id)
				<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/user', $user->id) }}" data-content="Are you sure you wish to delete this user?" data-title="Delete {{ htmlspecialchars($user->first_name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>

				@else
				<span class="btn delete-asset btn-danger disabled"><i class="icon-trash icon-white"></i></span>
				@endif
				@endif


			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>

<!-- {{
	Datatable::table()
		->addColumn(Lang::get('name'))
		->addColumn(Lang::get('email'))
		->addColumn('Assets')
		->addColumn('Licenses')
		->addColumn(Lang::get('activated'))
		->setUrl(route('api.users'))
		->render()
}} -->

@else


<div class="col-md-6">
	<div class="alert alert-warning alert-block">
		<i class="icon-warning-sign"></i>
		@lang('general.no_results')

	</div>
</div>
@endif

@stop
