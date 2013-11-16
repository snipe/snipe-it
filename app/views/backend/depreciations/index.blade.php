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
		Asset Depreciations

		<div class="pull-right">
			<a href="{{ route('create/depreciations') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

@if ($depreciations->getTotal()  > 10)
{{ $depreciations->links() }}
@endif

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span6">@lang('admin/depreciations/table.title')</th>
			<th class="span6">@lang('admin/depreciations/table.term')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($depreciations as $depreciation)
		<tr>
			<td>{{ $depreciation->name }}</td>
			<td>{{ $depreciation->months }} @lang('admin/depreciations/table.months') </td>
			<td>
				<a href="{{ route('update/depreciations', $depreciation->id) }}" class="btn btn-mini">@lang('button.edit')</a>
				<a href="{{ route('delete/depreciations', $depreciation->id) }}" class="btn btn-mini btn-danger">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@if ($depreciations->getTotal() > 10)
{{ $depreciations->links() }}
@endif

@stop
