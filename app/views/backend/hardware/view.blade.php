@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/hardware/general.view') {{ $asset->asset_tag }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<div class="btn-group pull-right">
			<button class="btn glow">@lang('button.actions')</button>
			<button class="btn glow dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu">

				@if ($asset->status_id == 1)
					@if ($asset->assigned_to != 0)
						<li><a href="{{ route('checkin/hardware', $asset->id) }}">@lang('admin/hardware/general.checkin')</a></li>
					@endif
				@elseif ($asset->status_id == 0)
						<li><a href="{{ route('checkout/hardware', $asset->id) }}">@lang('admin/hardware/general.checkout')</a></li>
				@endif
				<li><a href="{{ route('update/hardware', $asset->id) }}">@lang('admin/hardware/general.edit')</a></li>
				<li><a href="{{ route('clone/hardware', $asset->id) }}">@lang('admin/hardware/general.clone')</a></li>
			</ul>
		</div>
		<h3>
		<h3 class="name">
		@lang('admin/hardware/general.view') {{ $asset->asset_tag }}

		{{ $asset->asset_tag }}
		@if ($asset->name)
		({{ $asset->name }})
		@endif
	</h3>
	</div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

	<div class="col-md-12" style="min-height: 130px;">

		@if ($asset->model->manufacturer)
			<div class="col-md-6"><strong>@lang('admin/hardware/form.manufacturer'): </strong>
			{{ $asset->model->manufacturer->name }} </div>
			<div class="col-md-6"><strong>@lang('admin/hardware/form.model'):</strong>
			{{ $asset->model->name }} / {{ $asset->model->modelno }}</div>
		@endif

		@if ($asset->purchase_date)
			<div class="col-md-6"><strong>@lang('admin/hardware/form.date'): </strong>
			{{ $asset->purchase_date }} </div>
		@endif

		@if ($asset->purchase_cost)
			<div class="col-md-6"><strong>@lang('admin/hardware/form.cost'):</strong>
			@lang('general.currency')
			{{ number_format($asset->purchase_cost,2) }} </div>
		@endif

		@if ($asset->order_number)
			<div class="col-md-6"><strong>@lang('admin/hardware/form.order'):</strong>
			{{ $asset->order_number }} </div>
		@endif

		@if ($asset->warranty_months)
			<div class="col-md-6"><strong>@lang('admin/hardware/form.warranty'):</strong>
			{{ $asset->warranty_months }}
			@lang('admin/hardware/form.months')
			</div>
			<div class="col-md-6"><strong>@lang('admin/hardware/form.expires'):</strong>
			{{ $asset->warrantee_expires() }}</div>
		@endif

		@if ($asset->depreciation)
			<div class="col-md-6"><strong>@lang('admin/hardware/form.depreciation'): </strong>
			{{ $asset->depreciation->name }}
				({{ $asset->depreciation->months }}
				@lang('admin/hardware/form.months')
				)</div>
			<div class="col-md-6"><strong>@lang('admin/hardware/form.depreciates_on'): </strong>
			{{ $asset->depreciated_date() }} </div>
			<div class="col-md-6"><strong>@lang('admin/hardware/form.fully_depreciated'): </strong>
			{{ $asset->months_until_depreciated()->m }}
			@lang('admin/hardware/form.months')
			 @if ($asset->months_until_depreciated()->y > 0)
				, {{ $asset->months_until_depreciated()->y }}
				@lang('admin/hardware/form.years')
			 @endif
			 </div>
		@endif

		@if ($asset->model->eol)
			<div class="col-md-6"><strong>@lang('admin/hardware/form.eol_rate'): </strong>
			{{ $asset->model->eol }}
			@lang('admin/hardware/form.months') </div>
			<div class="col-md-6"><strong>@lang('admin/hardware/form.eol_date'): </strong>
			{{ $asset->eol_date() }}
			@if ($asset->months_until_eol())
				 (
				 @if ($asset->months_until_eol()->y > 0)
				 {{ $asset->months_until_eol()->y }}
				  @lang('general.years'),
				 @endif

				{{ $asset->months_until_eol()->m }}
				@lang('general.months')
				)
			@endif
			</div>
		@endif

	</div>


		<!-- checked out assets table -->

		<table class="table table-hover">
			<thead>
				<tr>
					<th class="col-md-1"></th>
					<th class="col-md-3"><span class="line"></span>Date</th>
					<th class="col-md-2"><span class="line"></span>Admin</th>
					<th class="col-md-2"><span class="line"></span>Action</th>
					<th class="col-md-2"><span class="line"></span>User</th>
					<th class="col-md-3"><span class="line"></span>Note</th>
				</tr>
			</thead>
			<tbody>
			@if (count($asset->assetlog) > 0)
				@foreach ($asset->assetlog as $log)
				<tr>
					<td>
					@if ((isset($log->checkedout_to)) && ($log->checkedout_to == $asset->assigned_to))
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
						@if (isset($log->checkedout_to))
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
					<td>{{ $asset->created_at }}</td>
					<td>
					@if ($asset->adminuser->id)
					{{ $asset->adminuser->fullName() }}
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

			@if ($qr_code->display)
			<h6>@lang('admin/hardware/form.qr')</h6>
			<p>
				<img src="{{ $qr_code->url }}" />
			</p>
			@endif

			@if ((isset($asset->assigned_to ) && ($asset->assigned_to > 0)))
				<h6><br>@lang('admin/hardware/form.checkedout_to')</h6>
				<ul>

					<li><img src="{{ $asset->assigneduser->gravatar() }}" class="img-circle" style="width: 100px; margin-right: 20px;" /><br /><br /></li>
					<li><a href="{{ route('view/user', $asset->assigned_to) }}">{{ $asset->assigneduser->fullName() }}</a></li>


					@if (isset($asset->assetloc->address))
						<li>{{ $asset->assetloc->address }}
						@if (isset($asset->assetloc->address2))
							{{ $asset->assetloc->address2 }}
						@endif
						</li>
						@if (isset($asset->assetloc->city))
							<li>{{ $asset->assetloc->city }}, {{ $asset->assetloc->state }} {{ $asset->assetloc->zip }}</li>
						@endif

					@endif

					@if (isset($asset->assigneduser->email))
						<li><br /><i class="icon-envelope-alt"></i> <a href="mailto:{{ $asset->assigneduser->email }}">{{ $asset->assigneduser->email }}</a></li>
					@endif

					@if (isset($asset->assigneduser->phone))
						<li><i class="icon-phone"></i> {{ $asset->assigneduser->phone }}</li>
					@endif

					<li><br /><a href="{{ route('checkin/hardware', $asset->id) }}" class="btn-flat large info ">@lang('admin/hardware/general.checkin')</a></li>
					</ul>

			@elseif (($asset->status_id ) && ($asset->status_id > 1))

				@if ($asset->assetstatus)
					<h6><br>{{ $asset->assetstatus->name }}
					@lang('admin/hardware/general.asset')</h6>

					<div class="col-md-12">
					<div class="alert alert-warning alert-block">
						<i class="icon-warning-sign"></i>
						@lang('admin/hardware/message.undeployable')

					</div>
				</div>
				@endif

			@elseif ($asset->status_id == NULL)
					<h6><br>@lang('admin/hardware/general.pending')</h6>
					<div class="col-md-12">
					<div class="alert alert-info alert-block">
						<i class="icon-info-sign"></i>
						@lang('admin/hardware/message.undeployable')
					</div>
				</div>

			@else
			<h6><br>@lang('admin/hardware/general.checkout')</h6>
				<ul>
					<li>This asset is not checked out to anyone yet. Use the button below to check it out now.</li>
					<li><br><br /><a href="{{ route('checkout/hardware', $asset->id) }}" class="btn-flat large success">Checkout Asset</a></li>
				</ul>
			@endif
		</div>
	</div>
</div>
@stop