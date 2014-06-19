@extends('backend/layouts/default')

@section('title0')
    @if (Input::get('Pending') || Input::get('Undeployable') || Input::get('RTD')  || Input::get('Deployed'))
        @if (Input::get('Pending'))
            @lang('general.pending')
        @elseif (Input::get('RTD'))
            @lang('general.ready_to_deploy')
        @elseif (Input::get('Undeployable'))
            @lang('general.undeployable')
        @elseif (Input::get('Deployed'))
            @lang('general.deployed')
        @endif
    @else
            @lang('general.all')
    @endif

    @lang('general.assets')
@stop

{{-- Page title --}}
@section('title')
    @yield('title0') :: @parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/hardware') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> @lang('general.create')</a>
		<h3>@yield('title0')</h3>
	</div>
</div>

<div class="row form-wrapper">

@if ($assets->count() > 0)


<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-1" bSortable="true">@lang('admin/hardware/table.asset_tag')</th>
			<th class="col-md-3" bSortable="true">@lang('admin/hardware/table.title')</th>
			@if (Setting::getSettings()->display_asset_name)
			<th class="col-md-3" bSortable="true">@lang('general.name')</th>
			@endif
			<th class="col-md-2" bSortable="true">@lang('admin/hardware/table.serial')</th>
			@if (Input::get('Pending') || Input::get('Undeployable') || Input::get('RTD'))
			<th class="col-md-2" bSortable="true">@lang('general.status')</th>
			@else
			<th class="col-md-2" bSortable="true">@lang('admin/hardware/table.checkoutto')</th>
			<th class="col-md-2" bSortable="true">@lang('admin/hardware/table.location')</th>
			@endif
			<th class="col-md-2">@lang('admin/hardware/table.eol')</th>
			<th class="col-md-1">@lang('admin/hardware/table.change')</th>
			<th class="col-md-2 actions" bSortable="false">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>

		@foreach ($assets as $asset)
		<tr>
			<td><a href="{{ route('view/hardware', $asset->id) }}">{{ $asset->asset_tag }}</a></td>
			<td><a href="{{ route('view/hardware', $asset->id) }}">{{ $asset->model->name }}</a></td>
			@if (Setting::getSettings()->display_asset_name)
				<td><a href="{{ route('view/hardware', $asset->id) }}">{{ $asset->name }}</a></td>
			@endif
			<td>{{ $asset->serial }}</td>
			@if (Input::get('Pending') || Input::get('Undeployable') || Input::get('RTD'))
				<td>
					@if (Input::get('Pending'))
						@lang('general.pending')
					@elseif (Input::get('RTD'))
						@lang('general.ready_to_deploy')
					@elseif (Input::get('Undeployable'))
						@if ($asset->assetstatus)
						{{ $asset->assetstatus->name }}
						@endif
                    @endif
				</td>
			@else
				<td>
				@if ($asset->assigneduser)
					<a href="{{ route('view/user', $asset->assigned_to) }}">
					{{ $asset->assigneduser->fullName() }}
					</a>
				@endif
				</td>
				<td>
				@if ($asset->assigneduser && $asset->assetloc)
						{{ $asset->assetloc->name }}
				@else
					@if ($asset->assetstatus)
						{{ $asset->assetstatus->name }}
					@endif
				@endif
				</td>

			@endif

			<td>
			@if ($asset->model->eol)
				{{ $asset->eol_date() }}
			@endif
			</td>

			<td>
			@if ($asset->status_id < 1 )
			@if ($asset->assigned_to != 0)
				<a href="{{ route('checkin/hardware', $asset->id) }}" class="btn btn-primary">@lang('general.checkin')</a>
			@else
				<a href="{{ route('checkout/hardware', $asset->id) }}" class="btn btn-info">@lang('general.checkout')</a>
			@endif
			@endif
			</td>
			<td nowrap="nowrap">
				<a href="{{ route('update/hardware', $asset->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
				<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/hardware', $asset->id) }}" data-content="@lang('admin/hardware/message.delete.confirm')"
				data-title="@lang('general.delete')
				 {{ htmlspecialchars($asset->asset_tag) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@else
<div class="col-md-9">
	<div class="alert alert-info alert-block">
		<i class="icon-info-sign"></i>
		@lang('general.no_results')
	</div>
</div>

</div>
@endif


@stop
