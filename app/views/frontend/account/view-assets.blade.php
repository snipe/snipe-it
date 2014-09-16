@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
View Assets for  {{{ $user->fullName() }}} ::
@parent
@stop

{{-- Account page content --}}
@section('account-content')

<div class="row profile">
            <!-- header -->
            <div class="row header">
                <div class="col-md-9">
                    <img src="{{{ $user->gravatar() }}}" class="avatar img-circle">
                    <h3 class="name">{{{ $user->fullName() }}}</h3>
                    <span class="area">{{{ $user->jobtitle }}}</span>
                </div>
        	</div>

            <div class="row profile">

                    <!-- bio, new note & orders column -->
                    <div class="col-md-10 bio">
                        <div class="profile-box">

                        @if ($user->deleted_at != NULL)

                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    <i class="icon-exclamation-sign"></i>
                                    <strong>Warning: </strong>
                                     This user has been deleted. You will have to restore this user to edit them or assign them new assets.
                                </div>
                            </div>

                        @endif


                            <!-- checked out assets table -->
                            @if (count($user->assets) > 0)
                            <h4>Assets Checked Out to You</h4>
                            <br>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-3">Asset Type</th>
                                        <th class="col-md-2"><span class="line"></span>Asset Tag</th>
                                        <th class="col-md-2"><span class="line"></span>Name</th>
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
                            @endif


                            <!-- checked out assets table -->
                            @if (count($user->licenses) > 0)
                            <h4>Software Checked Out to You</h4>
                            <br>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-4"><span class="line"></span>Name</th>
                                        <th class="col-md-4"><span class="line"></span>Serial</th>

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
                            @endif




                            <!-- checked out assets table -->
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
                                        <td>{{{ $log->added_on }}}</td>
                                        <td>{{{ $log->action_type }}}</td>
                                        <td>
                                        @if ((isset($log->assetlog->name)) && ($log->assetlog->deleted_at==''))
                                            {{{ $log->assetlog->asset_tag }}}
                                        @elseif ((isset($log->assetlog->name)) && ($log->assetlog->deleted_at!=''))
                                            <del>{{{ $log->assetlog->name }}}</del> (deleted)
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

