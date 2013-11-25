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

<table id="example">
	<thead>
		<tr role="row">
			<th class="span3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.title')</th>
			<th class="span3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.serial')</th>
			<th class="span3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.assigned_to')</th>
			<th class="span2" tabindex="0" rowspan="1" colspan="1">@lang('table.actions')</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th class="span3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.title')</th>
			<th class="span3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.serial')</th>
			<th class="span3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.assigned_to')</th>
			<th class="span2" tabindex="0" rowspan="1" colspan="1">@lang('table.actions')</th>
		</tr>
	</tfoot>
	<tbody>


		@foreach ($licenses as $license)

			<tr>

					<td><a href="{{ route('view/license', $license->id) }}">{{ $license->name }}</a>
					@if ($license->seats ==1)
						({{ $license->seats }} seat)
					@else
						({{ $license->seats }} seats)
					@endif

					</td>
					<td><a href="{{ route('view/license', $license->id) }}">{{ $license->serial }}</a></td>
					<td></td>
					<td>

					<a href="{{ route('update/license', $license->id) }}" class="btn-flat white"> @lang('button.edit')</a>
						<a class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/license', $license->id) }}" data-content="Are you sure you wish to delete the  {{ $license->name }} license?" data-title="Delete {{ $license->name }}?" onClick="return false;">@lang('button.delete')</a>


					</td>
				</tr>
				@if ($license->licenseseats)
				<?php $count=1; ?>
				@foreach ($license->licenseseats as $licensedto)

				<tr>


					<td>
					@if ($licensedto->assigned_to)
						<a href="{{ route('checkin/license', $licensedto->id) }}" class="btn-flat info"> Checkin </a>
					@else
						<a href="{{ route('checkout/license', $licensedto->id) }}" class="btn-flat success">Checkout</a>
					@endif
					</td>
					<td>{{ $license->name }} Seat {{ $count }}</td>



					<td>
					@if ($licensedto->assigned_to)
						<a href="{{ route('view/user', $licensedto->id) }}">
					{{ $licensedto->user->fullName() }}
					</a>
					@endif
					</td>
					<td></td>



				</tr>
				<?php $count++; ?>
				@endforeach
				@endif


		@endforeach







	</tbody>
</table>

@stop
