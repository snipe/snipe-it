@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
View Assets for  {{{ $user->fullName() }}} ::
@parent
@stop

{{-- Account page content --}}
@section('content')

<div class="row user-profile">
            <!-- header -->
            <div class="row header">
                <div class="col-md-8">
                    @if ($user->avatar)
                        <img src="/uploads/avatars/{{{ $user->avatar }}}" class="avatar img-circle">
                    @else
                        <img src="{{{ $user->gravatar() }}}" class="avatar img-circle">
                    @endif
                    <h3 class="name">{{{ $user->fullName() }}}</h3>
                    <span class="area">{{{ $user->jobtitle }}}
                        </span>
                </div>
        	</div>

            <div class="row profile">

                    <!-- bio, new note & orders column -->
                    <div class="col-md-10 bio">
                        <div class="profile-box">

                        @if ($user->deleted_at != NULL)

                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    <i class="fa fa-exclamation-circle"></i>
                                    <strong>Warning: </strong>
                                     This user has been deleted. You will have to restore this user to edit them or assign them new assets.
                                </div>
                            </div>

                        @endif


                            <!-- checked out assets table -->
                            @if (count($user->assets) > 0)
                            
                            <h4>Assets Checked Out to You</h4>
                            <br>
							<div class="table-responsive">
							<table class="display">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Asset Type</th>
                                        <th class="col-md-2">Asset Tag</th>
                                        <th class="col-md-2">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->assets as $asset)
                                    <tr>
                                        <td>
                                        @if ($asset->physical=='1') {{{ $asset->model->name }}}
                                        @endif
                                        </td>
                                        <td>{{{ $asset->asset_tag }}}</td>
                                        <td>{{{ $asset->name }}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
							</div>
                            @endif


                            <!-- checked out assets table -->
                            @if (count($user->licenses) > 0)
                            <br><br><br>
                            <h4>Software Checked Out to You</h4>
                            <br>
                            <div class="table-responsive">
							<table class="display">                                
								<thead>
                                    <tr>
                                        <th class="col-md-4">Name</th>
                                        <th class="col-md-4">Serial</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->licenses as $license)
                                    <tr>
                                        <td>{{{ $license->name }}}</td>
                                        <td>{{{ $license->serial }}}</td>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            @endif




                            <!-- checked out assets table -->
                            <br><br><br>
                            <h4>History </h4>
                            <br>
                            @if (count($user->userlog) > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Date</th>
                                        <th class="col-md-3"><span class="line"></span>Action</th>
                                        <th class="col-md-3"><span class="line"></span>Asset</th>
                                        <th class="col-md-3"><span class="line"></span>By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->userlog as $log)
                                    <tr>
                                        <td>{{{ $log->created_at }}}</td>
                                        <td>{{{ $log->action_type }}}</td>
                                        <td>
                                        @if ((isset($log->assetlog->name)) && ($log->assetlog->deleted_at==''))
                                            {{{ $log->assetlog->asset_tag }}}
                                        @elseif ((isset($log->assetlog->name)) && ($log->assetlog->deleted_at!=''))
                                            <del>{{{ $log->assetlog->name }}}</del> (deleted)
                                            
                                        @elseif ((isset($log->accessorylog->name)) && ($log->accessorylog->deleted_at==''))
                                            {{{ $log->accessorylog->name }}}
                                        @endif
                                        </td>
                                        <td>{{{ $log->adminlog->fullName() }}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif

                        </div>
                    </div>

@stop

