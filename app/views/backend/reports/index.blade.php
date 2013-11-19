@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Depreciation Report
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="page-header">
	<h3>
		Depreciation Report

		<div class="pull-right">
			<div class="btn-group settings">
				<button class="btn glow"><i class="icon-download-alt"></i></button>
				<button class="btn glow dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="#">Download as CSV</a></li>
					<li><a href="#">Download as PDF</a></li>
				</ul>
			</div>
		</div>

	</h3>
</div>


<div class="row-fluid table">
<table class="table table-hover">
	<thead>
		<tr>
			<th class="span2">@lang('admin/assets/table.asset_tag')</th>
			<th class="span2"><span class="line"></span>@lang('admin/assets/table.title')</th>
			<th class="span2"><span class="line"></span>@lang('admin/assets/table.serial')</th>
			<th class="span3"><span class="line"></span>@lang('admin/assets/table.checkoutto')</th>
			<th class="span2"><span class="line"></span>@lang('admin/assets/table.location')</th>
			<th class="span2"><span class="line"></span>@lang('admin/assets/table.purchase_date')</th>
			<th class="span1 align-right"><span class="line"></span>@lang('admin/assets/table.purchase_cost')</th>
			<th class="span1 align-rightt"><span class="line"></span>@lang('admin/assets/table.book_value')</th>
			<th class="span1 align-right"><span class="line"></span>Diff</th>
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
				<a href="{{ route('view/user', $asset->assigned_to) }}">
				{{ $asset->assigneduser->fullName() }}
				</a>
			@endif
			</td>
			<td>
			@if (($asset->assigned_to > 0) && ($asset->assigneduser->location_id > 0))
					{{ Location::find($asset->assigneduser->location_id)->city }}
					,
					{{ Location::find($asset->assigneduser->location_id)->state }}
			@endif
			</td>
			<td>{{ $asset->purchase_date }}</td>
			<td class="align-right">${{ number_format($asset->purchase_cost) }}</td>
			<td class="align-right">${{ number_format($asset->depreciation()) }}</td>
			<td class="align-right">-${{ ($asset->purchase_cost - $asset->depreciation()) }}</td>

		</tr>
		@endforeach
	</tbody>
</table>
</div>


@stop
