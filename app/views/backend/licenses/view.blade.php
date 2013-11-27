@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
View License {{ $license->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->
				<h3 class="name">History for ({{ $license->name }})


							<div class="btn-group pull-right">
                                <button class="btn glow">Actions</button>
                                <button class="btn glow dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">

                                	@if ($license->assigned_to != 0)
										<li><a href="{{ route('checkin/license', $license->id) }}" class="btn-flat info">Checkin</a></li>
									@else
										<li><a href="{{ route('checkout/license', $license->id) }}" class="btn-flat success">Checkout</a></li>
									@endif
                                    <li><a href="{{ route('update/license', $license->id) }}">Edit License</a></li>
                                </ul>
                            </div>
				</h3>

                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="span9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

							<h6>{{ $license->seats }} License Seats</h6>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    	<th class="span2">Seat</th>
                                         <th class="span6">User</th>
                                         <th class="span2"></th>
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
												<a href="{{ route('view/user', $licensedto->id) }}">
											{{ $licensedto->user->fullName() }}
											</a>
											@endif
											</td>
											<td>
											@if ($licensedto->assigned_to)
												<a href="{{ route('checkin/license', $licensedto->id) }}" class="btn-flat info"> Checkin </a>
											@else
												<a href="{{ route('checkout/license', $licensedto->id) }}" class="btn-flat success">Checkout</a>
											@endif
											</td>

										</tr>
										<?php $count++; ?>
										@endforeach
										@endif


                                </tbody>
                            </table>
							<br>
							<h6>Checkout History</h6>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    	<th class="span1"></th>
                                        <th class="span3"><span class="line"></span>Date</th>
                                        <th class="span3"><span class="line"></span>Admin</th>
                                        <th class="span3"><span class="line"></span>Action</th>
                                        <th class="span3"><span class="line"></span>User</th>
                                        <th class="span3"><span class="line"></span>Note</th>
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
										<td>{{ $license->created_at }}</td>
										<td>
										@if (isset($license->adminuser->id))
										{{ $license->adminuser->fullName() }}
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
                    <h6><br>License Info:</h6>
                       		<ul>
								@if ($license->serial)
								<li>Serial: {{ $license->serial }} </li>
								@endif
								@if ($license->license_name)
								<li>License Name: {{ $license->license_name }} </li>
								@endif
								@if ($license->license_email)
								<li>License Email: {{ $license->license_email }} </li>
								@endif
								@if ($license->purchase_date)
								<li>Purchase Date: {{ $license->purchase_date }} </li>
								@endif
								@if ($license->purchase_cost)
								<li>Purchase Cost: ${{ number_format($license->purchase_cost) }} </li>
								@endif
								@if ($license->order_number)
								<li>Order #: {{ $license->order_number }} </li>
								@endif
								@if ($license->seats)
								<li>Seats: {{ $license->seats }} </li>
								@endif
								@if ($license->seats)
								<li>Depreciation: {{ $license->depreciation->name }} ({{ $license->depreciation->months }} months)</li>
								@endif
							</ul>

                    </div>
@stop