@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
View User {{ $user->fullName() }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->
                <div class="row-fluid header">
                    <div class="span8">
                        <img src="{{ $user->gravatar() }}" class="avatar img-circle">
                        <h3 class="name">{{ $user->fullName() }}</h3>
                        <span class="area">{{ $user->jobtitle }}</span>
                    </div>

                    <a href="{{ route('update/user', $user->id) }}" class="btn-flat white large pull-right edit"><i class="icon-pencil"></i> @lang('button.edit') This User</a>
                </div>

                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="span9 bio">
                        <div class="profile-box">


                            <h6>Assets Checked Out to {{ $user->first_name }}</h6>
                            <br>
                            <!-- checked out assets table -->
                            @if (count($user->assets) > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    	<th class="span3">Asset Type</th>
                                        <th class="span3"><span class="line"></span>Asset Tag</th>
                                        <th class="span3"><span class="line"></span>Name</th>
                                        <th class="span3"><span class="line"></span>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($user->assets as $asset)
									<tr>
										<td>
										@if ($asset->physical=='1')
										Hardware
										@else
										Software
										@endif
										</td>
										<td><a href="{{ route('view/hardware', $asset->id) }}">{{ $asset->asset_tag }}</a></td>
										<td><a href="{{ route('view/hardware', $asset->id) }}">{{ $asset->name }}</a></td>

										<td> <a href="{{ route('checkin/hardware', $asset->id) }}" class="btn-flat info">Checkin</a></td>
									</tr>
									@endforeach
                                </tbody>
                            </table>
                            @else

                            <div class="col-md-6">
								<div class="alert alert-warning alert-block">
									<i class="icon-warning-sign"></i>
									@lang('admin/users/table.noresults')
								</div>
							</div>
                            @endif

                             <h6>Software Checked Out to {{ $user->first_name }}</h6>
                            <br>
                            <!-- checked out assets table -->
                            @if (count($user->licenses) > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                    	<th class="span3">Asset Type</th>
                                    	<th class="span3">Serial</th>
                                        <th class="span3"><span class="line"></span>Name</th>
                                        <th class="span3"><span class="line"></span>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($user->licenses as $license)
									<tr>
										<td>
										@if ($license->physical=='0')
										Hardware
										@else
										Software
										@endif
										</td>
										<td><a href="{{ route('view/license', $license->id) }}">{{ $license->serial }}</a></td>
										<td><a href="{{ route('view/license', $license->id) }}">{{ $license->name }}</a></td>

										<td> <a href="{{ route('checkin/license', $license->id) }}" class="btn-flat info">Checkin</a></td>
									</tr>
									@endforeach
                                </tbody>
                            </table>
                            @else

                            <div class="col-md-6">
								<div class="alert alert-warning alert-block">
									<i class="icon-warning-sign"></i>
									@lang('admin/users/table.noresults')
								</div>
							</div>
                            @endif



							<h6>History for {{ $user->first_name }}</h6>
                            <br>
                            <!-- checked out assets table -->
                            @if (count($user->userlog) > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="span3">Date</th>
                                        <th class="span3"><span class="line"></span>Action</th>
                                        <th class="span3"><span class="line"></span>Asset</th>
                                        <th class="span3"><span class="line"></span>By</th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($user->userlog as $log)
									<tr>
										<td>{{ $log->added_on }}</td>
										<td>{{ $log->action_type }}</td>
										<td>
										@if ((isset($log->assetlog->name)) && ($log->assetlog->deleted_at==''))
											<a href="{{ route('view/hardware', $log->asset_id) }}">{{ $log->assetlog->name }}</a>
										@elseif ((isset($log->assetlog->name)) && ($log->assetlog->deleted_at!=''))
											<del>{{ $log->assetlog->name }}</del> (deleted)
										@else
										missing asset ({{ $log->assetlog->name }}) ({{ $log->assetlog->deleted_at }})
										@endif
										</td>
										<td>{{ $log->adminlog->fullName() }}</td>
									</tr>
									@endforeach
                                </tbody>
                            </table>
                            @else

                            <div class="col-md-6">
								<div class="alert alert-warning alert-block">
									<i class="icon-warning-sign"></i>
									@lang('admin/users/table.noresults')
								</div>
							</div>
                            @endif

                        </div>
                    </div>

                    <!-- side address column -->
                    <div class="span3 address pull-right">


                        <h6>Contact  {{ $user->first_name }}</h6>

                        		@if ($user->location_id)
                        			<iframe width="300" height="133" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?&amp;q={{ $user->userloc->address }},{{ $user->userloc->city }},{{ $user->userloc->state }},{{ $user->userloc->country }}&amp;output=embed"></iframe>
                        		@endif
						<ul>
						@if ($user->location_id)
							<li>{{ $user->userloc->address }} {{ $user->userloc->address2 }}</li>
							<li>{{ $user->userloc->city }}, {{ $user->userloc->state }} {{ $user->userloc->zip }}<br /><br /></li>
						@endif
                        @if ($user->phone)
                        	<li><i class="icon-phone"></i>{{ $user->phone }}</li>
                        @endif
	                    	<li><i class="icon-envelope-alt"></i><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></li>
                        </ul>

                        @if ($user->last_login!='')
                    	<br /><h6>Last Login: {{ $user->last_login->diffForHumans() }}</h6>
                        @endif
                    </div>
@stop