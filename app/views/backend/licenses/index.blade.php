@extends('backend/layouts/default')

{{-- Page title --}}
@lang('admin/licenses/general.software_licenses') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/licenses') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> Create New</a>
		<h3>@lang('admin/licenses/general.software_licenses')</h3>
	</div>
</div>

<div class="row form-wrapper">

<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.title')</th>
			<th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.serial')</th>
			<th class="col-md-2" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.assigned_to')</th>
			<th class="col-md-1 actions" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/general.in_out')</th>
			<th class="col-md-1 actions" tabindex="0" rowspan="1" colspan="1">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>


		@foreach ($licenses as $license)

				@if ($license->licenseseats)
				<?php $count=1; ?>
				@foreach ($license->licenseseats as $licensedto)

				<tr>

					<td><a href="{{ route('view/license', $license->id) }}">{{ $license->name }}</a>
					 (Seat {{ $count }})
					 </td>
					<td><a href="{{ route('view/license', $license->id) }}">{{ Str::limit($license->serial, 40); }}</a>
					</td>
					<td>
					@if (($licensedto->assigned_to) && ($licensedto->deleted_at == NULL))
						<a href="{{ route('view/user', $licensedto->assigned_to) }}">
					{{ $licensedto->user->fullName() }}
					</a>
					@elseif (($licensedto->assigned_to) && ($licensedto->deleted_at != NULL))
						<del>{{ $licensedto->user->fullName() }}</del>
					@endif
					</td>
					<td>
					@if ($licensedto->assigned_to)
						<a href="{{ route('checkin/license', $licensedto->id) }}" class="btn btn-primary">
						@lang('general.checkin')</a>
					@else
						<a href="{{ route('checkout/license', $licensedto->id) }}" class="btn btn-info">
						@lang('general.checkout')</a>
					@endif
					</td>
					<td>
					@if ($count==1)
					<a href="{{ route('update/license', $license->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
						<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/license', $license->id) }}"
						data-content="@lang('admin/licenses/message.delete.confirm')"
						data-title="@lang('general.delete')
						 {{ htmlspecialchars($license->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
					@endif

					</td>



				</tr>
				<?php $count++; ?>
				@endforeach
				@endif


		@endforeach







	</tbody>
</table>

@stop
