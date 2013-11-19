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

                    <div class="span8">
                        <h3 class="name">{{ $asset->asset_tag }} ({{ $asset->name }})</h3>
                    </div>

                <a href="{{ route('update/asset', $asset->id) }}" class="btn-flat white large pull-right edit"><i class="icon-pencil"></i> @lang('button.edit') This Asset</a>

                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="span9 bio">
                        <div class="profile-box">
							<h6>History for {{ $asset->asset_tag }}</h6>
                            <br>
                            <!-- checked out assets table -->
                            @if (count($asset->assetlog) > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="span3">Date</th>
                                        <th class="span3"><span class="line"></span>Admin</th>
                                        <th class="span3"><span class="line"></span>Action</th>
                                        <th class="span3"><span class="line"></span>Asset</th>
                                         <th class="span3"><span class="line"></span>User</th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach ($asset->assetlog as $log)
									<tr>
										<td>{{ $log->added_on }}</td>
										<td>
											@if (isset($log->user_id))
											{{ $log->adminlog->fullName() }}
											@endif
										</td>
										<td>{{ $log->action_type }}</td>
										<td>{{ $log->assetlog->name }}</td>
										<td>
											@if (isset($log->checkedout_to))
											<a href="{{ route('view/user', $log->checkedout_to) }}">
											{{ $log->userlog->fullName() }}
											</a>
											@endif
										</td>
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

                        <h6>Address</h6>
                        <iframe width="300" height="133" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.mx/?ie=UTF8&amp;t=m&amp;ll=19.715081,-155.071421&amp;spn=0.010746,0.025749&amp;z=14&amp;output=embed"></iframe>
                        <ul>
                            <li>2301 East Lamar Blvd. Suite 140. </li>
                            <li>City, Arlington. United States,</li>
                            <li>Zip Code, TX 76006.</li>

                        </ul>
                    </div>
@stop