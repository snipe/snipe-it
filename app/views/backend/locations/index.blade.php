@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Locations ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/location') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.create')</a>
		<h3>@lang('admin/locations/table.locations')</h3>
	</div>
</div>

<div class="row form-wrapper">

<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-3">@lang('admin/locations/table.name')</th>
			<th class="col-md-3">@lang('admin/locations/table.address')</th>
			<th class="col-md-2">@lang('admin/locations/table.city'),
			 @lang('admin/locations/table.state')
			@lang('admin/locations/table.country')</th>
			<th class="col-md-2 actions">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($locations as $location)
		<tr>
			<td>{{ $location->name }}</td>
			<td>{{ $location->address }}, {{ $location->address2 }}  </td>
			<td>{{ $location->city }}, {{ $location->state }}  {{ $location->country }}  </td>
			<td>
				<a href="{{ route('update/location', $location->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
				<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/location', $location->id) }}" data-content="@lang('admin/locations/message.delete.confirm')"
				data-title="@lang('general.delete')
				 {{ htmlspecialchars($location->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>

			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>


@stop
