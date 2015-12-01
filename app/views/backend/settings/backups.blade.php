@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @lang('admin/settings/general.backups') ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="user-profile">
                <!-- header -->


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="col-md-9 bio">
                        <h3 class="name">@lang('admin/settings/general.backups')</h3>
                        @if (Config::get('app.lock_passwords'))
                           <p class="help-block">@lang('general.feature_disabled')</p>
                        @endif

                        <div class="profile-box">
                            <br>
                            <!-- Backups table -->

                            <table class="table table-hover">
                                <thead>
                                    <th>File</th>
                                    <th>Created</th>
                                    <th>Size</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                    <tr>
                                        <td><a href="backups/download/{{{ $file['filename'] }}}">{{{ $file['filename'] }}}</a></td>
                                        <td>{{{ date("M d, Y g:i A", $file['modified']) }}} </td>
                                        <td>{{{ $file['filesize'] }}}</td>
                                        <td>
                                            <a data-html="false"
                                            class="btn delete-asset btn-danger btn-sm {{ (Config::get('app.lock_passwords')) ? ' disabled': '' }}" data-toggle="modal" href=" {{ route('settings/delete-file', $file['filename']) }}" data-content="@lang('admin/settings/message.backup.delete_confirm')" data-title="{{ Lang::get('general.delete') }}  {{ htmlspecialchars($file['filename']) }} ?" onClick="return false;">
                                                <i class="fa fa-trash icon-white"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                     <!-- side address column -->
                    <div class="col-md-3 address pull-right">
                        <br><br>

                        <form method="POST">
                          {{ Form::hidden('_token', csrf_token()) }}

                            <p>
                                <button class="btn btn-default {{ (Config::get('app.lock_passwords')) ? ' disabled': '' }}">@lang('admin/settings/general.generate_backup')</button>
                            </p>

                             @if (Config::get('app.lock_passwords'))
                                <p class="help-block">@lang('general.feature_disabled')</p>
                             @endif


                        </form>
                        <p>Backup files are located in: app/storage/dumps</p>



                    </div>


@stop
