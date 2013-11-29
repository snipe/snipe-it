@extends('backend/layouts/default')

{{-- Page title --}}
Licenses ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/licenses') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> Create New</a>
		<h3>Software Licenses</h3>
	</div>
</div>

<div class="row form-wrapper">

<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.title')</th>
			<th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.serial')</th>
			<th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.assigned_to')</th>
			<th class="col-md-2" tabindex="0" rowspan="1" colspan="1">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>


		@foreach ($licenses as $license)

			<tr>

					<td><a href="{{ route('view/license', $license->id) }}">{{ $license->name }}</a>
					@if ($license->seats == 1)
						({{ $license->seats }} seat)
					@else
						({{ $license->seats }} seats)
					@endif

					</td>
					<td><a href="{{ route('view/license', $license->id) }}">{{ $license->serial }}</a></td>
					<td></td>
					<td>
					<a href="{{ route('update/license', $license->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
						<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/license', $license->id) }}" data-content="Are you sure you wish to delete this license?" data-title="Delete {{ htmlspecialchars($license->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>


					</td>
				</tr>
				@if ($license->licenseseats)
				<?php $count=1; ?>
				@foreach ($license->licenseseats as $licensedto)

				<tr>

					<td><a href="{{ route('view/license', $license->id) }}">{{ $license->name }}</a>
					 (Seat {{ $count }})
					 </td>
					<td><a href="{{ route('view/license', $license->id) }}">{{ $license->serial }}</a></td>
					<td>
					@if ($licensedto->assigned_to)
						<a href="{{ route('view/user', $licensedto->assigned_to) }}">
					{{ $licensedto->user->fullName() }}
					</a>
					@endif
					</td>
					<td>
					@if ($licensedto->assigned_to)
						<a href="{{ route('checkin/license', $licensedto->id) }}" class="btn btn-primary">Checkin</a>
					@else
						<a href="{{ route('checkout/license', $licensedto->id) }}" class="btn btn-info">Checkout</a>
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
