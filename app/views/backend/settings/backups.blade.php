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
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

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
                                        <td><a href="backups/delete/{{{ $file['filename'] }}}">{{{ $file['filename'] }}}</a></td>
                                        <td>{{{ date("M d, Y g:i A", $file['modified']) }}} </td>
                                        <td>{{{ $file['filesize'] }}}</td>
                                        <td>
                                            <a data-html="false"
                                            class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href=" {{ route('settings/delete-file', $file['filename']) }}" data-content="@lang('admin/settings/message.backup.delete_confirm')" data-title="{{ Lang::get('general.delete') }}  {{ htmlspecialchars($file['filename']) }} ?" onClick="return false;">
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
                        <br /><br />

                        <form method="POST">
                            <button class="btn btn-default">@lang('admin/settings/general.generate_backup')</button>
                        </form>
                        <br /><br />

                        <p>Backup files are located in: app/storage/dumps</p>



                    </div>


@stop
