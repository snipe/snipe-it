@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
View Asset {{ $asset->asset_tag }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<div class="btn-group pull-right">
			<button class="btn glow">Actions</button>
			<button class="btn glow dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu">

				@if ($asset->status_id == 1)
					@if ($asset->assigned_to != 0)
						<li><a href="{{ route('checkin/hardware', $asset->id) }}" class="btn-flat info">Checkin</a></li>
					@endif
				@elseif ($asset->status_id == 0)
						<li><a href="{{ route('checkout/hardware', $asset->id) }}" class="btn-flat success">Checkout</a></li>
				@endif
				<li><a href="{{ route('update/hardware', $asset->id) }}">Edit Asset</a></li>
				<li><a href="{{ route('clone/hardware', $asset->id) }}">Clone Asset</a></li>
			</ul>
		</div>
		<h3>
		<h3 class="name">History for {{ $asset->asset_tag }}
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
			<div class="col-md-6"><strong>Manufacturer: </strong> {{ $asset->model->manufacturer->name }} </div>
			<div class="col-md-6"><strong>Model:</strong> {{ $asset->model->name }} / {{ $asset->model->modelno }}</div>
		@endif

		@if ($asset->purchase_date)
			<div class="col-md-6"><strong>Purchased On: </strong>{{ $asset->purchase_date }} </div>
		@endif

		@if ($asset->purchase_cost)
			<div class="col-md-6"><strong>Purchase Cost:</strong> ${{ number_format($asset->purchase_cost,2) }} </div>
		@endif

		@if ($asset->order_number)
			<div class="col-md-6"><strong>Order #:</strong> {{ $asset->order_number }} </div>
		@endif

		@if ($asset->warranty_months)
			<div class="col-md-6"><strong>Warranty:</strong> {{ $asset->warranty_months }} months</div>
			<div class="col-md-6"><strong>Expires:</strong> {{ $asset->warrantee_expires() }}</div>
		@endif

		@if ($asset->depreciation)
			<div class="col-md-6"><strong>Depreciation: </strong>{{ $asset->depreciation->name }}
				({{ $asset->depreciation->months }} months)</div>
			<div class="col-md-6"><strong>Depreciates On: </strong>{{ $asset->depreciated_date() }} </div>
			<div class="col-md-6"><strong>Fully Depreciated: </strong>{{ $asset->months_until_depreciated()->m }} months,
			{{ $asset->months_until_depreciated()->y }} years</div>
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
					Unknown Admin
					@endif
					</td>
					<td>created asset</td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>


    	</div>

		<!-- side address column -->
		<div class="col-md-3 col-xs-12 address pull-right">

			@if ((isset($asset->assigned_to ) && ($asset->assigned_to > 0)))
				<h6><br>Checked Out To:</h6>
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

					<li><br /><a href="{{ route('checkin/hardware', $asset->id) }}" class="btn-flat large info ">Checkin Asset</a></li>
					</ul>

			@elseif (($asset->status_id ) && ($asset->status_id > 1))

				@if ($asset->assetstatus)
					<h6><br>{{ $asset->assetstatus->name }} Asset</h6>

					<div class="col-md-6">
					<div class="alert alert-warning alert-block">
						<i class="icon-warning-sign"></i>
						<strong>Warning: </strong> This asset has been marked <strong>{{ $asset->assetstatus->name }}</strong> and is currently undeployable.
						If this status has changed, please update the asset status.
					</div>
				</div>
				@endif

			@elseif ($asset->status_id == NULL)
					<h6><br>Pending Asset</h6>
					<div class="col-md-12">
					<div class="alert alert-info alert-block">
						<i class="icon-info-sign"></i>
						<strong>Warning: </strong> This asset has been marked as pending and is currently undeployable.
						If this status has changed, please update the asset status.
					</div>
				</div>

			@else
			<h6><br>Checkout Asset</h6>
				<ul>
					<li>This asset is not checked out to anyone yet. Use the button below to check it out now.</li>
					<li><br><br /><a href="{{ route('checkout/hardware', $asset->id) }}" class="btn-flat large success">Checkout Asset</a></li>
				</ul>
			@endif
		</div>
	</div>
</div>
@stop