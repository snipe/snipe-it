@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/licenses/general.view') {{ $license->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('update/license', $license->id) }}" class="btn-flat white pull-right"> @lang('admin/licenses/form.update')</a>
			<h3 class="name">@lang('general.history_for') {{ $license->name }}</h3>
	</div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

<h6>@lang('admin/licenses/general.info')</h6>

<div class="col-md-12">
@if ($license->serial)
<div class="col-md-6"><strong>@lang('admin/licenses/form.serial'): </strong> {{ $license->serial }} </div>
@endif

@if ($license->license_name)
<div class="col-md-6"><strong>@lang('admin/licenses/form.to_name'): </strong> {{ $license->license_name }} </div>
@endif

@if ($license->license_email)
<div class="col-md-6"><strong>@lang('admin/licenses/form.to_email'): </strong> {{ $license->license_email }} </div>
@endif

@if ($license->notes)
<div class="col-md-6"><strong>@lang('admin/licenses/form.notes'): </strong>{{ $license->notes }}</div>
@endif


<br><br><br>
</div>




				<!-- checked out assets table -->
				<h6>{{ $license->seats }} @lang('admin/licenses/general.license_seats')</h6>
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="col-md-2">@lang('admin/licenses/general.seat')</th>
							 <th class="col-md-6">@lang('admin/licenses/general.user')</th>
							 <th class="col-md-2"></th>
						</tr>
					</thead>
					<tbody>
					<?php $count=1; ?>
						@if ($license->licenseseats)
							@foreach ($license->licenseseats as $licensedto)

							<tr>
								<td>Seat {{ $count }} </td>
								<td>
								@if ($licensedto->assigned_to)
									<a href="{{ route('view/user', $licensedto->assigned_to) }}">
								{{ $licensedto->user->fullName() }}
								</a>
								@endif
								</td>
								<td>
								@if ($licensedto->assigned_to)
									<a href="{{ route('checkin/license', $licensedto->id) }}" class="btn-flat info"> @lang('general.checkin') </a>
								@else
									<a href="{{ route('checkout/license', $licensedto->id) }}" class="btn-flat success">@lang('general.checkout')</a>
								@endif
								</td>

							</tr>
							<?php $count++; ?>
							@endforeach
							@endif


					</tbody>
				</table>
				<br>
				<h6>@lang('admin/licenses/general.checkout_history')</h6>

				<table class="table table-hover">
					<thead>
						<tr>
							<th class="col-md-1"></th>
							<th class="col-md-3"><span class="line"></span>@lang('general.date')</th>
							<th class="col-md-3"><span class="line"></span>@lang('general.admin')</th>
							<th class="col-md-3"><span class="line"></span>@lang('button.actions')</th>
							<th class="col-md-3"><span class="line"></span>@lang('admin/licenses/general.user')</th>
							<th class="col-md-3"><span class="line"></span>@lang('admin/licenses/form.notes')</th>
						</tr>
					</thead>
					<tbody>
						@if (count($license->assetlog) > 0)
						@foreach ($license->assetlog as $log)
						<tr>
							<td>
							@if ((isset($log->checkedout_to)) && ($log->checkedout_to == $license->assigned_to))
							<i class="icon-star"></i>
							@endif
							</td>
							<td>{{ $log->added_on }}</td>
							<td>
								@if (isset($log->user_id))
								{{ $log->adminlog->fullName() }}
								@endif
							</td>
							<td>{{ $log->action_type }}</td>

							<td>
								@if ($log->userlog)
								<a href="{{ route('view/user', $log->checkedout_to) }}">
								{{ $log->userlog->fullName() }}
								</a>
								@endif

							</td>
							<td>
								@if ($log->note)
								{{ $log->note }}
								@endif
							</td>
						</tr>
						@endforeach
						@endif
						<tr>
							<td></td>
							<td>{{ $license->created_at }}</td>
							<td>
							@if ($license->adminuser)
							{{ $license->adminuser->fullName() }}
							@else
							@lang('general.unknown_admin')
							@endif
							</td>
							<td>@lang('general.created_asset')</td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
		</div>

		<!-- side address column -->
		<div class="col-md-3 col-xs-12 address pull-right">
		<h6><br>@lang('general.moreinfo'):</h6>
				<ul>

					@if ($license->purchase_date > 0)
					<li>@lang('admin/licenses/form.date'): {{ $license->purchase_date }} </li>
					@endif
					@if ($license->purchase_cost > 0)
					<li>@lang('admin/licenses/form.cost'):
					@lang('general.currency')
					{{ number_format($license->purchase_cost,2) }} </li>
					@endif
					@if ($license->order_number)
					<li>@lang('admin/licenses/form.order'):
					{{ $license->order_number }} </li>
					@endif
					@if (($license->seats) && ($license->seats) > 0)
					<li>@lang('admin/licenses/form.seats'):
					{{ $license->seats }} </li>
					@endif
					@if ($license->depreciation)
					<li>@lang('admin/licenses/form.depreciation'):
					{{ $license->depreciation->name }} ({{ $license->depreciation->months }} months)</li>
					@endif
				</ul>
		</div>
	</div>
</div>
@stop