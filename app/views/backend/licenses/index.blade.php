@extends('backend/layouts/default')

{{-- Page title --}}
Licenses ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Software Licenses

		<div class="pull-right">
			<a href="{{ route('create/licenses') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>
@if (count($licenses) > 50)
{{ $licenses->links() }}
@endif
<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span1">@lang('admin/licenses/table.id')</th>
			<th class="span4">@lang('admin/licenses/table.title')</th>
			<th class="span4">@lang('admin/licenses/table.serial')</th>
			<th class="span4">@lang('admin/licenses/table.license_name')</th>
			<th class="span4">@lang('admin/licenses/table.license_email')</th>
			<th class="span4">@lang('admin/licenses/table.purchase_date')</th>
			<th class="span2">@lang('admin/licenses/table.assigned_to')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($licenses as $license)
		<tr>
			<td>{{ $license->id }}</td>
			<td>{{ $license->name }}</td>
			<td>{{ $license->serial }}</td>
			<td>{{ $license->license_name }}</td>
			<td>{{ $license->license_email }}</td>
			<td>{{ $license->purchase_date }}</td>
			<td> </td>
			<td>
				<a href="{{ route('update/license', $license->id) }}" class="btn btn-mini"><i class="icon-pencil"></i> @lang('button.edit')</a>
				<a href="{{ route('delete/license', $license->id) }}" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> @lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@if (count($licenses) > 50)
{{ $licenses->links() }}
@endif
@stop
