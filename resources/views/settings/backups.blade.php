@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.backups') }}
@parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <th>File</th>
              <th>Created</th>
              <th>Size</th>
              <th><span class="sr-only">{{ trans('general.delete') }}</span></th>
            </thead>
            <tbody>
            @foreach ($files as $file)
            <tr>
              <td><a href="backups/download/{{ $file['filename'] }}">{{ $file['filename'] }}</a></td>
              <td>{{ date("M d, Y g:i A", $file['modified']) }} </td>
              <td>{{ $file['filesize'] }}</td>
              <td>

                  @can('superadmin')
                      <a data-html="false"
                         class="btn delete-asset btn-danger btn-sm {{ (config('app.lock_passwords')) ? ' disabled': '' }}" data-toggle="modal" href=" {{ route('settings.backups.destroy', $file['filename']) }}" data-content="{{ trans('admin/settings/message.backup.delete_confirm') }}" data-title="{{ trans('general.delete') }}  {{ htmlspecialchars($file['filename']) }} ?" onClick="return false;">
                          <i class="fa fa-trash icon-white" aria-hidden="true"></i>
                          <span class="sr-only">{{ trans('general.delete') }}</span>
                      </a>
                  @endcan
              </td>
            </tr>
            @endforeach
            </tbody>
          </table>
      </div>
    </div>
</div>
</div>
   <!-- side address column -->
  <div class="col-md-3">

      <form method="POST">
        {{ Form::hidden('_token', csrf_token()) }}

          <p>
              <button class="btn btn-primary {{ (config('app.lock_passwords')) ? ' disabled': '' }}">{{ trans('admin/settings/general.generate_backup') }}</button>
          </p>

           @if (config('app.lock_passwords'))
              <p class="help-block">{{ trans('general.feature_disabled') }}</p>
           @endif


      </form>
      <p>Backup files are located in: {{ $path  }}</p>



  </div>


@stop
