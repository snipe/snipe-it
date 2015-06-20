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
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                    <tr>
                                        <td><a href="backups/download/{{{ $file['filename'] }}}">{{{ $file['filename'] }}}</a></td>
                                        <td>{{{ date("M d, Y g:i A", $file['modified']) }}} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                     <!-- side address column -->
                    <div class="col-md-3 address pull-right">
                        <br /><br />

                        <p>Backup files are located in: {{{ $path }}}</p>


                    </div>


@stop
