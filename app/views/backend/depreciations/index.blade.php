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
			<a href="{{ route('create/depreciations') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i> Create New</a>
		</div>
	</h3>
</div>

@if ($depreciations->getTotal()  > Setting::getSettings()->per_page)
{{ $depreciations->links() }}
@endif

<div class="row-fluid table">
<table class="table table-hover">
	<thead>
		<tr>
			<th class="span6">@lang('admin/depreciations/table.title')</th>
			<th class="span2"><span class="line"></span>@lang('admin/depreciations/table.term')</th>
			<th class="span2"><span class="line"></span>@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($depreciations as $depreciation)
		<tr>
			<td>{{ $depreciation->name }}</td>
			<td>{{ $depreciation->months }} @lang('admin/depreciations/table.months') </td>
			<td>
				<a href="{{ route('update/depreciations', $depreciation->id) }}" class="btn-flat white">@lang('button.edit')</a>
				<a class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/depreciations', $depreciation->id) }}" data-content="Are you sure you wish to delete the  {{ $depreciation->name }} depreciation class?" data-title="Delete {{ $depreciation->name }}?" onClick="return false;">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>

@if ($depreciations->getTotal() > Setting::getSettings()->per_page)
{{ $depreciations->links() }}
@endif

@stop
