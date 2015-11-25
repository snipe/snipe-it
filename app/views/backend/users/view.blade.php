@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/users/general.view_user', array('name' => $user->first_name)) ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="user-profile">
            <!-- header -->
            <div class="row header">
                <div class="col-md-8">
                    @if ($user->avatar)
                        <img src="/uploads/avatars/{{{ $user->avatar }}}" class="avatar img-circle hidden-print">
                    @else
                        <img src="{{{ $user->gravatar() }}}" class="avatar img-circle hidden-print">
                    @endif
                    <h3 class="name">{{{ $user->fullName() }}}
                    @if (!is_null($user->company))
                        - {{{ $user->company->name }}}
                    @endif
                    @if ($user->employee_num)
                    		({{{ $user->employee_num }}})
                        @endif</h3>
                    <span class="area">{{{ $user->jobtitle }}}


                        <!-- groups table -->
                        @if (count($user->groups) > 0)

                            @foreach ($user->groups as $group)
                            <a href="{{ route('update/group', $group->id) }}" class="label label-default">{{{ $group->name }}}</a>
                            @endforeach

                        @endif
					 </span>
                </div>
                @if ($user->deleted_at != NULL)
                            <a href="{{ route('restore/user', $user->id) }}" class="btn-flat white large pull-right edit"><i class="fa fa-pencil"></i> Restore This User</a>

                @else
                        <!--<a href="{{ route('update/user', $user->id) }}" class="btn btn-warning pull-right edit"><i class="fa fa-pencil"></i> @lang('button.edit') This User</a>-->
                    <div class="row header">

                        <div class="btn-group pull-right hidden-print" role="group">
                            <button class="btn btn-default" data-toggle="dropdown">@lang('button.actions')
                            <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('update/user', $user->id) }}">@lang('admin/users/general.edit')</a></li>
                                <li><a href="{{ route('clone/user', $user->id) }}">@lang('admin/users/general.clone')</a></li>
                                @if ((Sentry::getId() !== $user->id) && (!Config::get('app.lock_passwords')))
                                    <li><a href="{{ route('delete/user', $user->id) }}">@lang('button.delete')</a></li>
                                @endif
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
                                    <i class="fa fa-exclamation-circle"></i>

                                    @lang('admin/users/message.user_deleted_warning')

                                </div>
                            </div>

                        @endif

                            <h6>@lang('admin/users/general.assets_user', array('name' => $user->first_name))</h6>
                            <br>
                            <!-- checked out assets table -->
                            @if (count($user->assets) > 0)
	                            <div class="table-responsive">
						<table class="display table table-hover">
		                                <thead>
		                                    <tr>
		                                        <th class="col-md-3">@lang('admin/hardware/table.asset_model')</th>
		                                        <th class="col-md-2">@lang('admin/hardware/table.asset_tag')</th>
		                                        <th class="col-md-2">@lang('general.name')</th>
		                                        <th class="col-md-1 hidden-print">@lang('general.action')</th>
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

		                                        <td class="hidden-print"> <a href="{{ route('checkin/hardware', array('assetId'=> $asset->id, 'backto'=>'user')) }}" class="btn-flat info">Checkin</a></td>
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
                            <h6>@lang('admin/users/general.software_user', array('name' => $user->first_name))</h6>
                            <br>
                            <!-- checked out licenses table -->
                            @if (count($user->licenses) > 0)
                            <div class="table-responsive">
							<table class="display table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-5">@lang('general.name')</th>
                                        <th class="col-md-6">@lang('admin/hardware/form.serial')</th>
                                        <th class="col-md-1 hidden-print">@lang('general.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->licenses as $license)
                                    <tr>
                                        <td><a href="{{ route('view/license', $license->id) }}">{{{ $license->name }}}</a></td>
                                        <td><a href="{{ route('view/license', $license->id) }}">{{{ mb_strimwidth($license->serial, 0, 50, "...") }}}</a></td>
                                        <td class="hidden-print"> <a href="{{ route('checkin/license', array('licenseseat_id'=> $license->pivot->id, 'backto'=>'user')) }}" class="btn-flat info">Checkin</a>
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
                            <h6>@lang('general.accessories')</h6>
                            <br>
                            <!-- checked out licenses table -->
                            @if (count($user->accessories) > 0)
                            <div class="table-responsive">
							<table class="display table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-5">Name</th>
                                        <th class="col-md-1 hidden-print">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->accessories as $accessory)
                                    <tr>
                                        <td><a href="{{ route('view/accessory', $accessory->id) }}">{{{ $accessory->name }}}</a></td>
                                        <td class="hidden-print"> <a href="{{ route('checkin/accessory', array('accessory_id'=> $accessory->pivot->id, 'backto'=>'user')) }}" class="btn-flat info">Checkin</a>
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
                            <h6>@lang('general.consumables')</h6>
                            <br>
                            <!-- checked out licenses table -->
                            @if (count($user->consumables) > 0)
                            <div class="table-responsive">
							<table class="display table table-hover">
                                <thead>
                                    <tr>
                                        <th class="col-md-8">@lang('general.name')</th>
                                        <th class="col-md-4">@lang('general.date')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->consumables as $consumable)
                                    <tr>
                                        <td><a href="{{ route('view/consumable', $consumable->id) }}">{{{ $consumable->name }}}</a></td>
                                        <td>{{{ $consumable->created_at }}}</td>
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

                            <br />
                            <h6>@lang('general.file_uploads') [ <a href="#" data-toggle="modal" data-target="#uploadFileModal">@lang('button.add')</a> ]</h6>
                            <br />
                            <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-5">@lang('general.notes')</th>
                                                    <th class="col-md-5"><span class="line"></span>@lang('general.file_name')</th>
                                                    <th class="col-md-2"></th>
                                                    <th class="col-md-2"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($user->uploads) > 0)
                                                    @foreach ($user->uploads as $file)
                                                    <tr>
                                                        <td>
                                                            @if ($file->note) {{{ $file->note }}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                        {{{ $file->filename }}}
                                                        </td>
                                                        <td>
                                                            @if ($file->filename)
                                                            <a href="{{ route('show/userfile', [$user->id, $file->id]) }}" class="btn btn-default">Download</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/userfile', [$user->id, $file->id]) }}" data-content="Are you sure you wish to delete this file?" data-title="Delete {{{ $file->filename }}}?"><i class="fa fa-trash icon-white"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4">
                                                            @lang('general.no_results')
                                                        </td>
                                                    </tr>

                                                @endif

                                            </tbody>
                                </table>

                        <!-- Modal -->
                        <div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="uploadFileModalLabel">Upload File</h4>
                              </div>
                              {{ Form::open([
                              'method' => 'POST',
                              'route' => ['upload/user', $user->id],
                              'files' => true, 'class' => 'form-horizontal' ]) }}
                              <div class="modal-body">

                                <p>@lang('admin/users/general.filetype_info')</p>

                                 <div class="form-group col-md-12">
                                 <div class="input-group col-md-12">
                                    <input class="col-md-12 form-control" type="text" name="notes" id="notes" placeholder="Notes">
                                </div>
                                </div>
                                <div class="form-group col-md-12">
                                 <div class="input-group col-md-12">
                                    {{ Form::file('userfile[]', ['multiple' => 'multiple']) }}
                                </div>
                                </div>


                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('button.cancel')</button>
                                <button type="submit" class="btn btn-primary btn-sm">@lang('button.upload')</button>
                              </div>
                              {{ Form::close() }}
                            </div>
                          </div>
                        </div>

							<br>
                            <h6>@lang('admin/users/general.history_user', array('name' => $user->first_name))</h6>
                            <br>
                            <!-- checked out assets table -->
                            @if (count($user->userlog) > 0)
                            <div class="table-responsive">
                            <table class="table table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th class="col-md-1"></th>
                                        <th class="col-md-2">Date</th>
                                        <th class="col-md-2"><span class="line"></span>@lang('table.action')</th>
                                        <th class="col-md-3"><span class="line"></span>@lang('general.asset')</th>
                                        <th class="col-md-2"><span class="line"></span>@lang('table.by')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userlog as $log)
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
                                        <td>{{{ $log->created_at }}}</td>
                                        <td>{{{ $log->action_type }}}</td>
                                        <td>

                                            @if (($log->assetlog) && ($log->asset_type=="hardware"))

                                                @if ($log->assetlog->deleted_at=='')
                                                    <a href="{{ route('view/hardware', $log->asset_id) }}">
                                                        {{{ $log->assetlog->showAssetName() }}}
                                                    </a>
                                                @else
                                                    <del>{{{ $log->assetlog->showAssetName() }}}</del> (deleted)
                                                @endif

                                            @elseif (($log->licenselog) && ($log->asset_type=="software"))

                                                @if ($log->licenselog->deleted_at=='')
                                                    <a href="{{ route('view/license', $log->license_id) }}">
                                                        {{{ $log->licenselog->name }}}
                                                    </a>
                                                @else
                                                    <del>{{{ $log->licenselog->name }}}</del> (deleted)
                                                @endif

                                             @elseif (($log->consumablelog) && ($log->asset_type=="consumable"))

                                                 @if ($log->consumablelog->deleted_at=='')
                                                     <a href="{{ route('view/consumable', $log->consumable_id) }}">{{{ $log->consumablelog->name }}}</a>
                                                 @else
                                                     <del>{{{ $log->consumablelog->name }}}</del> (deleted)
                                                 @endif

                                            @elseif (($log->accessorylog) && ($log->asset_type=="accessory"))
                                                @if ($log->accessorylog->deleted_at=='')
                                                    <a href="{{ route('view/accessory', $log->accessory_id) }}">{{{ $log->accessorylog->name }}}</a>
                                                @else
                                                    <del>{{{ $log->accessorylog->name }}}</del> (deleted)
                                                @endif

                                             @else
                                                 @lang('general.bad_data')
                                            @endif

                                        </td>
                                        <td>{{{ $log->adminlog->fullName() }}}</td>
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


                    <!-- side address column -->
                    <div class="col-md-3 address pull-right hidden-print">


                        <h6> @lang('admin/users/general.contact_user', array('name' => $user->first_name)) </h6>

                        @if ($user->userloc)
	                        <div class="col-md-12">
	                            <iframe width="300" height="133" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?&amp;q={{{ $user->userloc->address }}},{{{ $user->userloc->city }}},{{{ strtoupper($user->userloc->state) }}},{{{ strtoupper($user->userloc->country) }}}&amp;output=embed" style="float: none;"></iframe>
	                         </div>
                        @endif
                        <ul>
                        @if ($user->phone)
                            <li><i class="fa fa-phone"></i>{{{ $user->phone }}}</li>
                        @endif
                            <li><i class="fa fa-envelope-o"></i><a href="mailto:{{{ $user->email }}}">{{{ $user->email }}}</a><br /><br /></li>
                        @if ($user->manager)
                            <li><strong> @lang('admin/users/table.manager'):</strong><br>
                            {{{ $user->manager->fullName() }}}</li>
                        @endif
                        @if ($user->userloc)
                            <li>{{{ $user->userloc->address }}} {{{ $user->userloc->address2 }}}</li>
                            <li>{{{ $user->userloc->city }}}, {{{ $user->userloc->state }}} {{{ $user->userloc->zip }}}</li>
                        @endif
                        </ul>

                        @if ($user->notes!='')
                        <ul>
                            <li><strong> @lang('admin/users/table.notes'):</strong><br>
                            {{{ $user->notes }}}</li>
                        </ul>
                        @endif


                        @if ($user->last_login!='')
                        <br /><h6>@lang('admin/users/general.last_login')
                        {{{ $user->last_login->diffForHumans() }}}</h6>
                        @endif



                    </div>

@stop
