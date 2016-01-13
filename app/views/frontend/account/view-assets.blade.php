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



                        <h4>@lang('admin/users/general.assets_user', array('name' => $user->first_name))</h4>
                        <br>
                        <!-- checked out assets table -->
                        @if (count($user->assets) > 0)
                          <div class="table-responsive">
                            <table class="display table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-4">@lang('admin/hardware/table.asset_model')</th>
                                        <th class="col-md-2">@lang('admin/hardware/table.asset_tag')</th>
                                        <th class="col-md-3">@lang('general.name')</th>
                                        <th></th>
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
                                        <td>

                                        @if (($asset->image) && ($asset->image!=''))
                                          <img src="{{ Config::get('app.url') }}/uploads/assets/{{{ $asset->image }}}" height="50" width="50">

                                        @elseif (($asset->model) && ($asset->model->image!=''))
                                          <img src="{{ Config::get('app.url') }}/uploads/models/{{{ $asset->model->image }}}" height="50" width="50">
                                        @endif

                                       </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                        @else

                        <div class="col-md-12">
                            <div class="alert alert-info alert-block">
                                <i class="fa fa-info-circle"></i>
                                @lang('general.no_results')
                            </div>
                        </div>
                        @endif

                        <br>
                        <h4>@lang('admin/users/general.software_user', array('name' => $user->first_name))</h4>
                        <br>
                        <!-- checked out licenses table -->
                        @if (count($user->licenses) > 0)
                        <div class="table-responsive">
                          <table class="display table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-5">@lang('general.name')</th>
                                    <th class="col-md-4">@lang('admin/hardware/form.serial')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->licenses as $license)
                                <tr>
                                    <td>{{{ $license->name }}}</td>
                                    <td>

                                       @if (($user->hasAccess('admin')) || ($user->hasAccess('license_keys')))

                                       {{{ mb_strimwidth($license->serial, 0, 50, "...") }}}
                                      @else
                                        ---
                                      @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @else

                        <div class="col-md-12">
                            <div class="alert alert-info alert-block">
                                <i class="fa fa-info-circle"></i>
                                @lang('general.no_results')
                            </div>
                        </div>
                        @endif




                        <br>
                        <h4>@lang('general.accessories')</h4>
                        <br>
                        <!-- checked out licenses table -->
                        @if (count($user->accessories) > 0)
                        <div class="table-responsive">
                          <table class="display table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-9">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->accessories as $accessory)
                                <tr>
                                    <td>{{{ $accessory->name }}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @else

                        <div class="col-md-12">
                            <div class="alert alert-info alert-block">
                                <i class="fa fa-info-circle"></i>
                                @lang('general.no_results')
                            </div>
                        </div>
                        @endif


                        <br>
                        <h4>@lang('general.consumables')</h4>
                        <br>
                        <!-- checked out consumables table -->
                        @if (count($user->consumables) > 0)
                        <div class="table-responsive">
                          <table class="display table table-hover">
                            <thead>
                                <tr>
                                    <th class="col-md-9">@lang('general.name')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->consumables as $consumable)
                                <tr>
                                    <td>{{{ $consumable->name }}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @else

                        <div class="col-md-12">
                            <div class="alert alert-info alert-block">
                                <i class="fa fa-info-circle"></i>
                                @lang('general.no_results')
                            </div>
                        </div>
                        @endif



                            <!-- checked out assets table -->
                            <br><br><br>
                            <h4>History </h4>
                            <!-- checked out assets table -->
                            @if (count($user->userlog) > 0)
                            <div class="table-responsive">
                            <table class="table table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th class="col-md-1"></th>
                                        <th class="col-md-2"><span class="line"></span>@lang('table.action')</th>
                                        <th class="col-md-4"><span class="line"></span>@lang('general.asset')</th>
                                        <th class="col-md-2"><span class="line"></span>@lang('table.by')</th>
                                        <th class="col-md-3">@lang('general.date')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->userlog as $log)
                                    <tr>
                                        <td class="text-center">
                                            @if (($log->assetlog) && ($log->asset_type=="hardware"))
                                                <i class="fa fa-barcode"></i>
                                            @elseif (($log->accessorylog) && ($log->asset_type=="accessory"))
                                                <i class="fa fa-keyboard-o"></i>
                                            @elseif (($log->consumablelog) && ($log->asset_type=="consumable"))
                                                <i class="fa fa-tint"></i>
                                            @elseif (($log->licenselog) && ($log->asset_type=="software"))
                                                <i class="fa fa-certificate"></i>
                                            @else
                                            <i class="fa fa-times"></i>
                                            @endif

                                        </td>
                                        <td>{{{ $log->action_type }}}</td>
                                        <td>

                                            @if (($log->assetlog) && ($log->asset_type=="hardware"))

                                                @if ($log->assetlog->deleted_at=='')

                                                        {{{ $log->assetlog->showAssetName() }}}

                                                @else
                                                    <del>{{{ $log->assetlog->showAssetName() }}}</del> (deleted)
                                                @endif

                                            @elseif (($log->licenselog) && ($log->asset_type=="software"))

                                                @if ($log->licenselog->deleted_at=='')

                                                        {{{ $log->licenselog->name }}}

                                                @else
                                                    <del>{{{ $log->licenselog->name }}}</del> (deleted)
                                                @endif

                                             @elseif (($log->consumablelog) && ($log->asset_type=="consumable"))

                                                 @if ($log->consumablelog->deleted_at=='')
                                                    {{{ $log->consumablelog->name }}}
                                                 @else
                                                     <del>{{{ $log->consumablelog->name }}}</del> (deleted)
                                                 @endif

                                            @elseif (($log->accessorylog) && ($log->asset_type=="accessory"))
                                                @if ($log->accessorylog->deleted_at=='')
                                                    {{{ $log->accessorylog->name }}}
                                                @else
                                                    <del>{{{ $log->accessorylog->name }}}</del> (deleted)
                                                @endif

                                             @else
                                                 @lang('general.bad_data')
                                            @endif

                                        </td>
                                        <td>{{{ $log->adminlog->fullName() }}}</td>
                                        <td>{{{ $log->created_at }}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            @else


                            <div class="col-md-12">
                                <div class="alert alert-info alert-block">
                                    <i class="fa fa-info-circle"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                        </div>
                    </div>

@stop
