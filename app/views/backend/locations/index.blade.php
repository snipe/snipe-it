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
			<a href="{{ route('create/location') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i> Create New</a>
		</div>
	</h3>
</div>

@if ($locations->getTotal() > 10)
{{ $locations->links() }}
@endif

<div class="row-fluid table">
<table class="table table-hover">
	<thead>
		<tr>
			<th class="span4">@lang('admin/locations/table.name')</th>
			<th class="span4"><span class="line"></span>Address</th>
			<th class="span4"><span class="line"></span>@lang('admin/locations/table.city'),
			 @lang('admin/locations/table.state')
			@lang('admin/locations/table.country')</th>
			<th class="span2"><span class="line"></span>@lang('table.actions')</th>
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
				<a href="{{ route('delete/location', $location->id) }}" class="btn-flat danger">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>

@if ($locations->getTotal() > 10)
{{ $locations->links() }}
@endif

@stop
