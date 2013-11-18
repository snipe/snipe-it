@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Assets ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Assets

		<div class="pull-right">
			<a href="{{ route('create/asset') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

@if ($assets->getTotal() > 10)
	{{ $assets->links() }}
@endif
<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span2">@lang('admin/assets/table.asset_tag')</th>
			<th class="span4">@lang('admin/assets/table.title')</th>
			<th class="span2">@lang('admin/assets/table.serial')</th>
			<th class="span2">@lang('admin/assets/table.status')</th>
			<th class="span2">@lang('admin/assets/table.purchase_date')</th>
			<th class="span2">@lang('admin/assets/table.purchase_cost')</th>
			<th class="span2">@lang('admin/assets/table.book_value')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($assets as $asset)
		<tr>
			<td>{{ $asset->asset_tag }}</td>
			<td>{{ $asset->name }}</td>
			<td>{{ $asset->serial }}</td>
			<td>

			@if ($asset->assigned_to != 0)
				{{ $asset->assigned_to }}
				<a href="{{ route('checkin/asset', $asset->id) }}" class="btn btn-mini">Checkin</a>
			@else
				<a href="{{ route('checkout/asset', $asset->id) }}" class="btn btn-mini">Checkout</a>
			@endif


			</td>
			<td>{{ $asset->purchase_date }}</td>
			<td>${{ number_format($asset->purchase_cost) }}</td>
			<td>${{ number_format($asset->depreciation()) }}</td>
			<td>
				<a href="{{ route('update/asset', $asset->id) }}" class="btn btn-mini">@lang('button.edit')</a>
				<a href="{{ route('delete/asset', $asset->id) }}" class="btn btn-mini btn-danger">@lang('button.delete')</a>

			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@if ($assets->getTotal() > 10)
{{ $assets->links() }}
@endif
@stop
