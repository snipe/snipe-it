@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/users/general.view_user', array('name' => $user->fullName())) }}
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-12">


      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#info_tab" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-info-circle"></i></span> <span class="hidden-xs hidden-sm">Info</span></a></li>
          <li><a href="#asset_tab" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-barcode"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.assets') }}</span></a></li>
          <li><a href="#licenses_tab" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-floppy-o"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.licenses') }}</span></a></li>
          <li><a href="#accessories_tab" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-keyboard-o"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.accessories') }}</span></a></li>
          <li><a href="#consumables_tab" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-tint"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.consumables') }}</span></a></li>
          <li><a href="#files_tab" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-paperclip"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.file_uploads') }}</span></a></li>
          <li><a href="#history_tab" data-toggle="tab"><span class="hidden-lg hidden-md"><i class="fa fa-clock-o"></i></span> <span class="hidden-xs hidden-sm">{{ trans('general.history') }}</span></a></li>

            @can('users.edit')
          <li class="dropdown pull-right">

            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-gear"></i> {{ trans('button.actions') }}
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('update/user', $user->id) }}">{{ trans('admin/users/general.edit') }}</a></li>
               <li><a href="{{ route('clone/user', $user->id) }}">{{ trans('admin/users/general.clone') }}</a></li>
               @if ((Auth::user()->id !== $user->id) && (!config('app.lock_passwords')) && ($user->deleted_at==''))
                   <li><a href="{{ route('delete/user', $user->id) }}">{{ trans('button.delete') }}</a></li>
               @endif
            </ul>
          </li>
            @endcan
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="info_tab">
            <div class="row">
                @if ($user->deleted_at!='')
                    <div class="col-md-12">
                    <div class="callout callout-warning">
                        <i class="icon fa fa-warning"></i>
                        This user has been marked as deleted.
                        @can('users.edit')
                            <a href="{{ route('restore/user', $user->id) }}">Click here</a> to restore them.
                        @endcan
                      </div>
                  </div>
                @endif
              <div class="col-md-1">
              @if ($user->avatar)
                <img src="/uploads/avatars/{{ $user->avatar }}" class="avatar img-thumbnail hidden-print">
              @else
                <img src="{{ $user->gravatar() }}" class="avatar img-circle hidden-print">
              @endif
            </div>
            <div class="col-md-8">

                <div class="table table-responsive">
                  <table class="table table-striped">
                    @if (!is_null($user->company))
                      <tr>
                          <td>Company</td>
                          <td>{{ $user->company->name }}</td>
                      </tr>
                    @endif

                    <tr>
                        <td>Name</td>
                        <td>{{ $user->fullName() }}</td>
                    </tr>
                    @if ($user->jobtitle)
                    <tr>
                        <td>Title</td>
                        <td>{{ $user->jobtitle }}</td>
                    </tr>
                    @endif

                    @if ($user->employee_num)
                    <tr>
                        <td>Employee No.</td>
                        <td>{{ $user->employee_num }}</td>
                    </tr>
                    @endif

                    @if ($user->manager)
                    <tr>
                        <td>Manager</td>
                        <td><a href="{{ route('view/user', $user->manager->id) }}">{{ $user->manager->fullName() }}</a></td>
                    </tr>
                    @endif

                    @if ($user->email)
                    <tr>
                        <td>Email</td>
                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                    </tr>
                    @endif

                    @if ($user->phone)
                    <tr>
                        <td>Phone</td>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    @endif

                    @if ($user->userloc)
                    <tr>
                        <td>Location</td>
                        <td>{{ $user->userloc->name }}</td>
                    </tr>
                    @endif
                    @if ($user->created_at)
                        <tr>
                            <td>{{ trans('general.created_at') }}</td>
                            <td>
                                {{ $user->created_at->format('F j, Y h:iA') }}
                            </td>
                        </tr>
                    @endif

                  </table>
                </div>
              </div>

              <!-- Start button column -->
              <div class="col-md-2">
                  @can('users.edit')
                  <div class="col-md-12">

                      <a href="{{ route('update/user', $user->id) }}" style="width: 100%;" class="btn btn-sm btn-default">{{ trans('admin/users/general.edit') }}</a>
                  </div>
                  <div class="col-md-12" style="padding-top: 5px;">
                      <a href="{{ route('clone/user', $user->id) }}" style="width: 100%;" class="btn btn-sm btn-default">{{ trans('admin/users/general.clone') }}</a>
                  </div>


                  @if ((Auth::user()->id !== $user->id) && (!config('app.lock_passwords')))

                    @if ($user->deleted_at=='')
                        <div class="col-md-12" style="padding-top: 5px;">
                            <a href="{{ route('delete/user', $user->id) }}" style="width: 100%;" class="btn btn-sm btn-warning">{{ trans('button.delete') }}</a>
                        </div>
                        <div class="col-md-12" style="padding-top: 5px;">
                            <form action="{{ route('users/bulkedit') }}" method="POST">
                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="edit_user[{{ $user->id }}]" value="{{ $user->id }}" />
                                <button style="width: 100%;" class="btn btn-sm btn-danger">{{ trans('button.checkin_and_delete') }}</button>
                            </form>
                        </div>
                    @else
                        <div class="col-md-12" style="padding-top: 5px;">
                            <a href="{{ route('restore/user', $user->id) }}" style="width: 100%;" class="btn btn-sm btn-warning">{{ trans('button.restore') }}</a>
                        </div>
                    @endif

                  @endif
                @endcan
              </div>
              <!-- End button column -->

            </div>



          </div><!-- /.tab-pane -->
          <div class="tab-pane" id="asset_tab">
            <!-- checked out assets table -->
              <div class="table-responsive">
                <table class="display table table-striped">
                  <thead>
                    <tr>
                      <th class="col-md-3">{{ trans('admin/hardware/table.asset_model') }}</th>
                      <th class="col-md-2">{{ trans('admin/hardware/table.asset_tag') }}</th>
                      <th class="col-md-2">{{ trans('general.name') }}</th>
                      <th class="col-md-1 hidden-print">{{ trans('general.action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($user->assets as $asset)
                    <tr>
                      <td>
                      @if ($asset->physical=='1') {{ $asset->model->name }}
                      @endif
                      </td>
                      <td>
                          @can('assets.view')
                              <a href="{{ route('view/hardware', $asset->id) }}">{{ $asset->asset_tag }}</a>
                          @endcan
                      </td>
                      <td><a href="{{ route('view/hardware', $asset->id) }}">{{ $asset->name }}</a></td>

                      <td class="hidden-print">
                          @can('assets.edit')
                              <a href="{{ route('checkin/hardware', array('assetId'=> $asset->id, 'backto'=>'user')) }}" class="btn btn-primary btn-sm">Checkin</a>
                          @endcan
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div><!-- /.tab-pane -->
          <div class="tab-pane" id="licenses_tab">
            <div class="table-responsive">
              <table class="display table table-hover">
                <thead>
                  <tr>
                    <th class="col-md-5">{{ trans('general.name') }}</th>
                    <th class="col-md-6">{{ trans('admin/hardware/form.serial') }}</th>
                    <th class="col-md-1 hidden-print">{{ trans('general.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($user->licenses as $license)
                  <tr>
                    <td>
                            <a href="{{ route('view/license', $license->id) }}">{{ $license->name }}</a>

                    </td>
                    <td><a href="{{ route('view/license', $license->id) }}">{{ mb_strimwidth($license->serial, 0, 50, "...") }}</a></td>
                    <td class="hidden-print">
                        @can('licenses.edit')
                            <a href="{{ route('checkin/license', array('licenseseat_id'=> $license->pivot->id, 'backto'=>'user')) }}" class="btn btn-primary btn-sm">Checkin</a>
                         @endcan
                    </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
            </div>
          </div><!-- /.tab-pane -->
          <div class="tab-pane" id="accessories_tab">
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
                        <td><a href="{{ route('view/accessory', $accessory->id) }}">{{ $accessory->name }}</a></td>
                        <td class="hidden-print">
                            @can('accessories.edit')
                                <a href="{{ route('checkin/accessory', array('accessory_id'=> $accessory->pivot->id, 'backto'=>'user')) }}" class="btn btn-primary btn-sm">Checkin</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div><!-- /.tab-pane -->
          <div class="tab-pane" id="consumables_tab">
            <div class="table-responsive">
              <table class="display table table-striped">
                <thead>
                    <tr>
                        <th class="col-md-8">{{ trans('general.name') }}</th>
                        <th class="col-md-4">{{ trans('general.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->consumables as $consumable)
                    <tr>
                        <td><a href="{{ route('view/consumable', $consumable->id) }}">{{ $consumable->name }}</a></td>
                        <td>{{ $consumable->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
          </div><!-- /.tab-pane -->
          <div class="tab-pane" id="files_tab">

            <div class="row">
            <div class="col-md-12 col-sm-12">
              <p>{{ trans('admin/hardware/general.filetype_info') }}</p>
            </div>
            <div class="col-md-2">
            <!-- The fileinput-button span is used to style the file input field as button -->
                @can('users.edit')
                    <span class="btn btn-info fileinput-button">
                    <i class="fa fa-plus icon-white"></i>
                    <span>Select File...</span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="file[]" data-url="{{ config('app.url') }}/api/users/{{ $user->id }}/upload">

                </span>
                    @endcan

            </div>
            <div class="col-md-4">
              <input id="notes" type="text" name="notes">
            </div>

            <div class="col-md-6" id="progress-container" style="visibility: hidden; padding-bottom: 20px;">
                <!-- The global progress bar -->
                <div class="col-md-11">
                    <div id="progress" class="progress progress-striped active" style="margin-top: 8px;">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                            <span id="progress-bar-text">0% Complete</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="pull-right progress-checkmark" style="display: none;">
                    </div>
                </div>
            </div>


            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lib/jquery.fileupload.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lib/jquery.fileupload-ui.css') }}">


            <div class="col-md-12 col-sm-12">

              <div class="table-responsive">
                <table class="display table table-striped">
                    <thead>
                        <tr>
                          <th class="col-md-5">{{ trans('general.notes') }}</th>
                          <th class="col-md-5"><span class="line"></span>{{ trans('general.file_name') }}</th>
                          <th class="col-md-2"></th>
                          <th class="col-md-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($user->uploads as $file)
                      <tr>
                          <td>
                            @if ($file->note) {{ $file->note }}
                            @endif
                          </td>
                          <td>
                          {{ $file->filename }}
                          </td>
                          <td>
                            @if ($file->filename)
                            <a href="{{ route('show/userfile', [$user->id, $file->id]) }}" class="btn btn-default">Download</a>
                            @endif
                          </td>
                          <td>
                              @can('users.edit')
                            <a class="btn delete-asset btn-danger btn-sm" href="{{ route('delete/userfile', [$user->id, $file->id]) }}" data-content="Are you sure you wish to delete this file?" data-title="Delete {{ $file->filename }}?"><i class="fa fa-trash icon-white"></i></a>
                              @endcan
                          </td>
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                </div>
              </div>
            </div>



          </div><!-- /.tab-pane -->
          <div class="tab-pane" id="history_tab">
            <div class="table-responsive">
            <table class="table table-striped" id="example">
              <thead>
                <tr>
                  <th class="col-md-1"></th>
                  <th class="col-md-2">Date</th>
                  <th class="col-md-2"><span class="line"></span>{{ trans('table.action') }}</th>
                  <th class="col-md-3"><span class="line"></span>{{ trans('general.asset') }}</th>
                  <th class="col-md-2"><span class="line"></span>{{ trans('table.by') }}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($userlog as $log)
                    <tr>
                      <td class="text-center">
                        @if ($log->itemType()=="asset")
                          <i class="fa fa-barcode"></i>
                        @elseif ($log->itemType()=="accessory")
                          <i class="fa fa-keyboard-o"></i>
                        @elseif ($log->itemType()=="consumable")
                          <i class="fa fa-tint"></i>
                        @elseif ($log->itemType()=="license")
                          <i class="fa fa-floppy-o"></i>
                        @else
                          <i class="fa fa-times"></i>
                        @endif

                      </td>
                      <td>{{ $log->created_at }}</td>
                      <td>{{ $log->action_type }}</td>
                      <td>

                        @if (($log->item) && ($log->itemType()=="asset"))
                            <a href="{{ route('view/hardware', $log->item_id) }}">{{ $log->item->asset_tag }} - {{ $log->item->showAssetName() }}</a>
                        @elseif ($log->item)
                            <a href="{{ route('view/'. $log->itemType(), $log->item_id) }}">{{ $log->item->name }}</a>
                        @else
                            {{ trans('general.bad_data') }}
                        @endif

                        </td>
                        <td>
                           @if ($log->action_type != 'requested')
                                @if (isset($log->user))
                                    <a href="{{route('view/user', $log->user_id)}}">{{ $log->user->fullName() }}</a>
                                @else
                                    Deleted Admin
                                @endif
                            @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
          </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
      </div><!-- nav-tabs-custom -->

    </div>
  </div>

@section('moar_scripts')
<script>
$(function () {
    //binds to onchange event of your input field
    var uploadedFileSize = 0;
    $('#fileupload').bind('change', function() {
      uploadedFileSize = this.files[0].size;
      $('#progress-container').css('visibility', 'visible');
    });

    $('#fileupload').fileupload({
        //maxChunkSize: 100000,
        dataType: 'json',
        formData:{
        _token:'{{ csrf_token() }}',
        notes: $('#notes').val(),
        },

        progress: function (e, data) {
            //var overallProgress = $('#fileupload').fileupload('progress');
            //var activeUploads = $('#fileupload').fileupload('active');
            var progress = parseInt((data.loaded / uploadedFileSize) * 100, 10);
            $('.progress-bar').addClass('progress-bar-warning').css('width',progress + '%');
            $('#progress-bar-text').html(progress + '%');
            //console.dir(overallProgress);
        },

        done: function (e, data) {
            console.dir(data);

            // We use this instead of the fail option, since our API
            // returns a 200 OK status which always shows as "success"

            if (data && data.jqXHR.responseJSON.error && data.jqXHR.responseJSON && data.jqXHR.responseJSON.error) {
                $('#progress-bar-text').html(data.jqXHR.responseJSON.error);
                $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-danger').css('width','100%');
                $('.progress-checkmark').fadeIn('fast').html('<i class="fa fa-times fa-3x icon-white" style="color: #d9534f"></i>');
                console.log(data.jqXHR.responseJSON.error);
            } else {
                $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-success').css('width','100%');
                $('.progress-checkmark').fadeIn('fast');
                $('#progress-container').delay(950).css('visibility', 'visible');
                $('.progress-bar-text').html('Finished!');
                $('.progress-checkmark').fadeIn('fast').html('<i class="fa fa-check fa-3x icon-white" style="color: green"></i>');
                $.each(data.result.file, function (index, file) {
                    $('<tr><td>' + file.notes + '</td><<td>' + file.name + '</td><td>Just now</td><td>' + file.filesize + '</td><td><a class="btn btn-info btn-sm" href="import/process/' + file.name + '"><i class="fa fa-spinner process"></i> Process</a></td></tr>').prependTo("#upload-table > tbody");
                    //$('<tr><td>').text(file.name).appendTo(document.body);
                });
            }
            $('#progress').removeClass('active');


        }
    });
});
</script>

@stop

@stop
