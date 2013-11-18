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
                                        <th class="span4"><span class="line"></span>Name</th>
                                        <th class="span2"><span class="line"></span>Date</th>
                                        <th class="span2"><span class="line"></span>Actions</th>
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
										<td>{{ $asset->asset_tag }}</td>
										<td>{{ $asset->name }}</td>
										<td></td>
										<td> <a href="{{ route('checkin/asset', $asset->id) }}" class="btn-flat info">Checkin</a></td>
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
                    	@if ($user->last_login!='')
                    	<ul>
                    		<li><strong>Last Login:</strong></li>
                            <li>{{ $user->last_login->diffForHumans() }}</li>
                        </ul>
                        @endif
                        <h6>Address</h6>
                        <iframe width="300" height="133" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.mx/?ie=UTF8&amp;t=m&amp;ll=19.715081,-155.071421&amp;spn=0.010746,0.025749&amp;z=14&amp;output=embed"></iframe>
                        <ul>
                            <li>2301 East Lamar Blvd. Suite 140. </li>
                            <li>City, Arlington. United States,</li>
                            <li>Zip Code, TX 76006.</li>
                            <li class="ico-li">
                                <i class="icon-phone"></i>
                               {{ $user->phone }}
                            </li>
                             <li class="ico-li">
                                <i class="icon-envelope-alt"></i>
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </li>
                        </ul>
                    </div>
@stop