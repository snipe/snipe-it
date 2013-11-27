@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
View Asset {{ $asset->asset_tag }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->
				<h3 class="name">History for {{ $asset->asset_tag }} ({{ $asset->name }})

							<div class="btn-group pull-right">
                                <button class="btn glow">Actions</button>
                                <button class="btn glow dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">

                                	@if ($asset->assigned_to != 0)
										<li><a href="{{ route('checkin/asset', $asset->id) }}" class="btn-flat info">Checkin</a></li>
									@else
										<li><a href="{{ route('checkout/asset', $asset->id) }}" class="btn-flat success">Checkout</a></li>
									@endif
                                    <li><a href="{{ route('update/asset', $asset->id) }}">Edit Asset</a></li>
                                    <li><a href="{{ route('clone/asset', $asset->id) }}">Clone Asset</a></li>
                                </ul>
                            </div>
				</h3>


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="span9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    	<th class="span1"></th>
                                        <th class="span3"><span class="line"></span>Date</th>
                                        <th class="span2"><span class="line"></span>Admin</th>
                                        <th class="span2"><span class="line"></span>Action</th>
                                        <th class="span2"><span class="line"></span>User</th>
                                        <th class="span3"><span class="line"></span>Note</th>
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
                    </div>

                    <!-- side address column -->
                    <div class="span3 address pull-right">

                    <h6><br>More Info:</h6>
                       		<ul>
								@if ($asset->model->manufacturer)
								<li>Manufacturer: {{ $asset->model->manufacturer->name }} </li>
								<li>Model: {{ $asset->model->name }} / {{ $asset->model->modelno }}</li>
								@endif

								@if ($asset->purchase_date)
								<li>Purchased On: {{ $asset->purchase_date }} </li>
								@endif

								@if ($asset->purchase_date)
								<li>Purchased On: {{ $asset->purchase_date }} </li>
								@endif

								@if ($asset->purchase_cost)
								<li>Purchase Cost: ${{ number_format($asset->purchase_cost,2) }} </li>
								@endif
								@if ($asset->order_number)
								<li>Order #: {{ $asset->order_number }} </li>
								@endif
								@if ($asset->warranty_months)
								<li>Warranty: {{ $asset->warranty_months }} months</li>
								<li>Expires: {{ $asset->warrantee_expires() }}</li>
								@endif

								@if ($asset->depreciation)
								<li>Depreciation: {{ $asset->depreciation->name }} ({{ $asset->depreciation->months }} months)</li>
								<li>Depreciates On: {{ $asset->depreciated_date() }} </li>
								<li>Fully Depreciated: {{ $asset->months_until_depreciated()->m }} months, {{ $asset->months_until_depreciated()->y }} years</li>
								@endif

							</ul>


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

								<li><br /><a href="{{ route('checkin/asset', $asset->id) }}" class="btn-flat large info ">Checkin Asset</a></li>
								</ul>

						@else
							<ul>
								<li><br><br /><a href="{{ route('checkout/asset', $asset->id) }}" class="btn-flat large success">Checkout Asset</a></li>
							</ul>
                        @endif
                    </div>
@stop