@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.user') 
{{{ $user->fullName() }}} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="user-profile">
            <!-- header -->
            <div class="row header">
                <div class="col-md-8">
                    <img src="{{{ $user->gravatar() }}}" class="avatar img-circle">
                    <h3 class="name">{{{ $user->fullName() }}}
                    @if ($user->employee_num)
                    		({{{ $user->employee_num }}})
                        @endif</h3>
                    <span class="area">{{{ $user->jobtitle }}}

                        </span>
                </div>
                @if ($user->deleted_at != NULL)
                            <a href="{{ route('restore/user', $user->id) }}" class="btn-flat white large pull-right edit"><i class="icon-pencil"></i>@lang('actions.restore')</a>

                @else
                        <!--<a href="{{ route('update/user', $user->id) }}" class="btn btn-warning pull-right edit"><i class="icon-pencil"></i> @lang('actions.edit') This User</a>-->
                    <div class="row header">

                        <div class="btn-group pull-right">
                            <button class="btn gray">@lang('actions.actions')</button>
                            <!--  Height being thrown off by sub-container  -->
                            <button class="btn glow dropdown-toggle" style="height: 27.5" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('update/user', $user->id) }}">@lang('base.user_update')</a></li>
                                <li><a href="{{ route('clone/user', $user->id) }}">@lang('base.user_clone')</a></li>
                            </ul>
                        </div>

                    </div>
                @endif
            </div>
            <div class="row profile">

                    <!-- bio, new note & orders column -->
                    <div class="col-md-9 bio">
                        <div class="profile-box">

                        @if ($user->deleted_at != NULL)

                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    <i class="icon-exclamation-sign"></i>
                                    <strong>[Warning:]</strong>
                                     [This user has been deleted. You will have to restore this user to edit them or assign them new assets.]
                                </div>
                            </div>

                        @endif

                            <h6>@lang('base.assets')</h6>
                            <br>
                            <!-- checked out assets table -->
                            @if (count($user->assets) > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Asset Type</th>
                                        <th class="col-md-2"><span class="line"></span>@lang('general.asset_tag')</th>
                                        <th class="col-md-2"><span class="line"></span>@lang('general.name')</th>
                                        <th class="col-md-1"><span class="line"></span>@lang('actions.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->assets as $asset)
                                    <tr>
                                        <td>
                                        @if ($asset->physical=='1') {{{ $asset->model->name }}}
                                        @endif
                                        </td>
                                        <td><a href="{{ route('view/hardware', $asset->id) }}">{{{ $asset->asset_tag }}}</a></td>
                                        <td><a href="{{ route('view/hardware', $asset->id) }}">{{{ $asset->name }}}</a></td>

                                        <td> <a href="{{ route('checkin/hardware', $asset->id) }}" class="btn btn-primary">@lang('actions.checkin')</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else

                            <div class="col-md-12">
                                <div class="alert alert-info alert-block">
                                    <i class="icon-info-sign"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif

                             <h6>@lang('base.licenses')</h6>
                            <br>
                            <!-- checked out assets table -->
                            @if (count($user->licenses) > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-4"><span class="line"></span>@lang('general.name')</th>
                                        <th class="col-md-4"><span class="line"></span>@lang('general.serialnumber')</th>
                                        <th class="col-md-1"><span class="line"></span>@lang('actions.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->licenses as $license)
                                    <tr>
                                        <td><a href="{{ route('view/license', $license->id) }}">{{{ $license->name }}}</a></td>
                                        <td><a href="{{ route('view/license', $license->id) }}">{{{ $license->serial }}}</a></td>
                                        <td> <a href="{{ route('checkin/license', $license->pivot->id) }}" class="btn btn-primary">@lang('actions.checkin')</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else

                            <div class="col-md-12">
                                <div class="alert alert-info alert-block">
                                    <i class="icon-info-sign"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif



                            <h6>@lang('general.history')</h6>
                            <br>
                            <!-- checked out assets table -->
                            @if (count($user->userlog) > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Date</th>
                                        <th class="col-md-3"><span class="line"></span>@lang('actions.actions')</th>
                                        <th class="col-md-3"><span class="line"></span>@lang('base.asset_shortname')</th>
                                        <th class="col-md-3"><span class="line"></span>[By]</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->userlog as $log)
                                    <tr>
                                        <td>{{{ $log->added_on }}}</td>
                                        <td>{{{ $log->action_type }}}</td>
                                        <td>

                                        @if ((isset($log->assetlog->name)) && ($log->assetlog->deleted_at==''))
                                            <a href="{{ route('view/hardware', $log->asset_id) }}">{{{ $log->assetlog->asset_tag }}}</a>
                                        @elseif ((isset($log->assetlog->name)) && ($log->assetlog->deleted_at!=''))
                                            <del>{{{ $log->assetlog->name }}}</del> (deleted)
                                        @endif
                                        </td>
                                        <td>{{{ $log->adminlog->fullName() }}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else


                            <div class="col-md-12">
                                <div class="alert alert-info alert-block">
                                    <i class="icon-info-sign"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

                    <!-- side address column -->
                    <div class="col-md-3 address pull-right">


                        <h6>@lang('general.contact'):</h6>


                        @if ($user->location_id)
                            <iframe width="300" height="133" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?&amp;q={{{ $user->userloc->address }}},{{{ $user->userloc->city }}},{{{ $user->userloc->state }}},{{{ $user->userloc->country }}}&amp;output=embed"></iframe>
                        @endif
                        
                        <ul>
                        @if ($user->location_id)
                        <li><a href="{{ route('view/location', $user->userloc->id) }}" >{{{ $user->userloc->name }}}</a></li>
                        @endif
                        
                        @if ($user->manager)
                        <li><strong>Manager:</strong> <a href="{{ route('view/user', $user->manager->id) }}" class="name">{{{ $user->manager->fullName() }}}</a></li>
                        @endif

                        @if ($user->location_id)
                            <li>{{{ $user->userloc->address }}} {{{ $user->userloc->address2 }}}</li>
                            <li>{{{ $user->userloc->city }}}, {{{ $user->userloc->state }}} {{{ $user->userloc->zip }}}<br /><br /></li>
                        @endif
                        @if ($user->phone)
                            <li><i class="icon-phone"></i>{{{ $user->phone }}}</li>
                        @endif
                            <li><i class="icon-envelope-alt"></i>{{HTML::mailto($user->email)}}</li>
                        </ul>

                        @if ($user->last_login!='')
                        <br /><h6>@lang('admin/users/form.last_login') : 
                            {{{ $user->last_login->diffForHumans() }}}</h6>
                        @endif
                    </div>
@stop
