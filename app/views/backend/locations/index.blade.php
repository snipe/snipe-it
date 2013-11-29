@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Locations ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">

	<div class="pull-right">
		<a href="{{ route('create/location') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i> Create New</a>
	</div>

	<h3>Locations</h3>
</div>

<div class="row-fluid table">
<table id="example">
	<thead>
		<tr role="row">
			<th class="span3">@lang('admin/locations/table.name')</th>
			<th class="span3">Address</th>
			<th class="span2">@lang('admin/locations/table.city'),
			 @lang('admin/locations/table.state')
			@lang('admin/locations/table.country')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($locations as $location)
		<tr>
			<td>{{ $location->name }}</td>
			<td>{{ $location->address }}, {{ $location->address2 }}  </td>
			<td>{{ $location->city }}, {{ $location->state }}  {{ $location->country }}  </td>
			<td>
				<a href="{{ route('update/location', $location->id) }}" class="btn-flat white"> @lang('button.edit')</a>
				<a data-html="false" class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/location', $location->id) }}" data-content="Are you sure you wish to delete this location?" data-title="Delete {{ htmlspecialchars($location->name) }}?" onClick="return false;">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>


@stop
