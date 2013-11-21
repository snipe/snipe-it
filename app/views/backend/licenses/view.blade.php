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

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    	<th class="span1"></th>
                                        <th class="span3"><span class="line"></span>Date</th>
                                        <th class="span3"><span class="line"></span>Admin</th>
                                        <th class="span3"><span class="line"></span>Action</th>
                                         <th class="span3"><span class="line"></span>User</th>
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
											@if (isset($log->checkedout_to->id))
											<a href="{{ route('view/user', $log->checkedout_to) }}">
											{{ $log->userlog->fullName() }}
											</a>
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
									</tr>
                                </tbody>
                            </table>



                        </div>
                    </div>

                    <!-- side address column -->
                    <div class="span3 address pull-right">

						@if ((isset($license->assigned_to ) && ($license->assigned_to > 0)))
                       		<h6><br>Checked Out To:</h6>
                       		<ul>

								<li><img src="{{ $license->assigneduser->gravatar() }}" class="img-circle" style="width: 100px; margin-right: 20px;" /><br /><br /></li>
								<li><a href="{{ route('view/user', $license->assigned_to) }}">{{ $license->assigneduser->fullName() }}</a></li>


								@if (isset($license->assetloc->address))
									<li>{{ $license->assetloc->address }}
									@if (isset($license->assetloc->address2))
										{{ $license->assetloc->address2 }}
									@endif
									</li>
									@if (isset($license->assetloc->city))
										<li>{{ $license->assetloc->city }}, {{ $license->assetloc->state }} {{ $license->assetloc->zip }}</li>
									@endif

								@endif



								@if (isset($license->assigneduser->email))
									<li><br /><i class="icon-envelope-alt"></i> <a href="mailto:{{ $license->assigneduser->email }}">{{ $license->assigneduser->email }}</a></li>
								@endif

								@if (isset($license->assigneduser->phone))
									<li><i class="icon-phone"></i> {{ $license->assigneduser->phone }}</li>
								@endif

								<li><br /><a href="{{ route('checkin/license', $license->id) }}" class="btn-flat large info ">Checkin Asset</a></li>
								</ul>

						@else
							<ul>
								<li><br><br />This asset is not currently assigned to anyone. You may check it into inventory
								using the button below, or mark it as lost/stolen using the menu above.</li>
								<li><br><br /><a href="{{ route('checkout/license', $license->id) }}" class="btn-flat large success">Checkout Asset</a></li>
							</ul>
                        @endif
                    </div>
@stop