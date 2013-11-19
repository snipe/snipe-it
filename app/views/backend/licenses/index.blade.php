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
			<a href="{{ route('create/licenses') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i> Create New</a>
		</div>
	</h3>
</div>
@if ($licenses->getTotal() > 10)
{{ $licenses->links() }}
@endif
<div class="row-fluid table">
<table class="table table-hover">
	<thead>
		<tr>
			<th class="span2">@lang('admin/licenses/table.title')</th>
			<th class="span2"><span class="line"></span>@lang('admin/licenses/table.serial')</th>
			<th class="span2"><span class="line"></span>@lang('admin/licenses/table.license_name')</th>
			<th class="span2"><span class="line"></span>@lang('admin/licenses/table.license_email')</th>
			<th class="span2"><span class="line"></span>@lang('admin/licenses/table.assigned_to')</th>
			<th class="span2"><span class="line"></span>@lang('admin/licenses/table.checkout')</th>
			<th class="span2"><span class="line"></span>@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($licenses as $license)
		<tr>
			<td><a href="{{ route('view/license', $license->id) }}">{{ $license->name }}</a></td>
			<td><a href="{{ route('view/license', $license->id) }}">{{ $license->serial }}</a></td>

			<td>{{ $license->license_name }}</td>
			<td>{{ $license->license_email }}</td>

			<td>
			@if ($license->assigned_to != 0)
				<a href="{{ route('view/user', $license->assigned_to) }}">
				{{ $license->assigneduser->fullName() }}
				</a>
			@endif
			</td>
			<td>
			@if ($license->assigned_to != 0)
				<a href="{{ route('checkin/license', $license->id) }}" class="btn-flat info">Checkin</a>
			@else
				<a href="{{ route('checkout/license', $license->id) }}" class="btn-flat success">Checkout</a>
			@endif
			</td>
			<td>
				<a href="{{ route('update/license', $license->id) }}" class="btn-flat white"> @lang('button.edit')</a>
				<a href="{{ route('delete/license', $license->id) }}"  class="btn-flat danger"> @lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>

@if ($licenses->getTotal() > 10)
{{ $licenses->links() }}
@endif
@stop
