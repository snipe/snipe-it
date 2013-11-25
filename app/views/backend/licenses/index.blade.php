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
@if ($licenses->getTotal() > Setting::getSettings()->per_page)
{{ $licenses->links() }}
@endif
<div class="row-fluid table">
<table class="table table-hover">
	<thead>
		<tr>
			<th class="span1">@lang('admin/licenses/table.seats')</th>
			<th class="span2"><span class="line"></span>@lang('admin/licenses/table.title')</th>
			<th class="span2"><span class="line"></span>@lang('admin/licenses/table.serial')</th>
			<th class="span2"><span class="line"></span>@lang('admin/licenses/table.license_name')</th>
			<th class="span2"><span class="line"></span>@lang('admin/licenses/table.license_email')</th>
			<th class="span2"><span class="line"></span>@lang('admin/licenses/table.assigned_to')</th>
			<th class="span2"><span class="line"></span>@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>


		@foreach ($licenses as $license)

			<tr>
					<td>{{ $license->seats }}</td>
					<td><a href="{{ route('view/license', $license->id) }}">{{ $license->name }}</a></td>
					<td><a href="{{ route('view/license', $license->id) }}">{{ $license->serial }}</a></td>
					<td>{{ $license->license_name }}</td>
					<td>{{ $license->license_email }} </td>

					<td></td>
					<td>

					<a href="{{ route('update/license', $license->id) }}" class="btn-flat white"> @lang('button.edit')</a>
						<a class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/license', $license->id) }}" data-content="Are you sure you wish to delete the  {{ $license->name }} license?" data-title="Delete {{ $license->name }}?" onClick="return false;">@lang('button.delete')</a>


					</td>
				</tr>
				@if ($license->licenseseats)

				@foreach ($license->licenseseats as $licensedto)

				<tr>

					<td></td>
					<td>
					@if ($licensedto->assigned_to)
						<a href="{{ route('checkin/license', $licensedto->id) }}" class="btn-flat info"> Checkin </a>
					@else
						<a href="{{ route('checkout/license', $licensedto->id) }}" class="btn-flat success">Checkout</a>
					@endif
					</td>
					<td><i class="icon-arrow-right"></i> {{ $license->serial }}</td>


					<td>{{ $license->license_name }}</td>
					<td>{{ $license->license_email }} </td>
					<td>
					@if ($licensedto->assigned_to)
						<a href="{{ route('view/user', $licensedto->id) }}">
					{{ $licensedto->user->fullName() }}
					</a>
					@endif
					</td>
					<td></td>



				</tr>
				@endforeach
				@endif


		@endforeach







	</tbody>
</table>
</div>

@if ($licenses->getTotal() > Setting::getSettings()->per_page)
{{ $licenses->links() }}
@endif
@stop
