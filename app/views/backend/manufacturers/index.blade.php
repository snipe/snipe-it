@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Asset Manufacturers ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Asset Manufacturers

		<div class="pull-right">
			<a href="#" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

{{ $manufacturers->links() }}

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span2">@lang('admin/manufacturers/table.id')</th>
			<th class="span6">@lang('admin/manufacturers/table.title')</th>
			<th class="span2">@lang('admin/manufacturers/table.created_at')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($manufacturers as $manufacturer)
		<tr>
			<td>{{ $manufacturer->id }}</td>
			<td>{{ $manufacturer->name }}</td>
			<td>{{ $manufacturer->created_at->diffForHumans() }}</td>
			<td>
				<a href="#" class="btn btn-mini">@lang('button.edit')</a>
				<a href="#" class="btn btn-mini btn-danger">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

{{ $manufacturers->links() }}
@stop
