@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Asset Depreciations ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Locations

		<div class="pull-right">
			<a href="{{ route('create/location') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

@if (count($locations) > 10)
{{ $locations->links() }}
@endif

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span6">@lang('admin/locations/table.name')</th>
			<th class="span6">@lang('admin/locations/table.city'),
			 @lang('admin/locations/table.state')
			@lang('admin/locations/table.country')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($locations as $location)
		<tr>
			<td>{{ $location->name }}</td>
			<td>{{ $location->city }}, {{ $location->state }}  {{ $location->country }}  </td>
			<td>
				<a href="{{ route('update/location', $location->id) }}" class="btn btn-mini">@lang('button.edit')</a>
				<a href="{{ route('delete/location', $location->id) }}" class="btn btn-mini btn-danger">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@if (count($locations) > 10)
{{ $locations->links() }}
@endif

@stop
