@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Asset Manufacturers ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">

	<div class="pull-right">
		<a href="{{ route('create/manufacturer') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i> Create New</a>
	</div>

	<h3>Asset Manufacturers</h3>
</div>


<div class="row-fluid table">
<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-6">@lang('admin/manufacturers/table.title')</th>
			<th class="col-md-3">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($manufacturers as $manufacturer)
		<tr>
			<td>{{ $manufacturer->name }}</td>
			<td>
				<a href="{{ route('update/manufacturer', $manufacturer->id) }}" class="btn-flat white">@lang('button.edit')</a>
				<a data-html="false" class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/manufacturer', $manufacturer->id) }}" data-content="Are you sure you wish to delete this manufacturer?" data-title="Delete {{ htmlspecialchars($manufacturer->name) }}?" onClick="return false;">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>

@stop
