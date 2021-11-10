@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.backups') }}
@parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-default pull-right" style="margin-left: 5px;"> 
      {{ trans('general.back') }}
    </a>

    <form method="POST" style="display: inline">
      {{ Form::hidden('_token', csrf_token()) }}
            <button class="btn btn-primary {{ (config('app.lock_passwords')) ? ' disabled': '' }}">{{ trans('admin/settings/general.generate_backup') }}</button>
      </form>

@stop

{{-- Page content --}}
@section('content')


<div class="row">

  <div class="col-md-9">
    
    <div class="box box-default">
      <div class="box-body">
       
        
          
        <div class="table-responsive">
          
            <table
                    data-cookie="true"
                    data-cookie-id-table="system-backups"
                    data-pagination="true"
                    data-id-table="system-backups"
                    data-search="true"
                    data-side-pagination="client"
                    data-sort-order="asc"
                    id="system-backups"
                    class="table table-striped snipe-table">
            <thead>
              <tr>
              <th data-sortable="true">File</th>
              <th data-sortable="true" data-field="modified_display" data-sort-name="modified_value">Created</th>
              <th data-field="modified_value" data-visible="false"></th>
              <th data-sortable="true">Size</th>
              <th><span class="sr-only">{{ trans('general.delete') }}</span></th>
              </tr>
            </thead>
            <tbody>
            @foreach ($files as $file)
            <tr>
              <td>
                  <a href="{{ route('settings.backups.download', [$file['filename']]) }}">
                      {{ $file['filename'] }}
                  </a>
              </td>
              <td>{{ $file['modified_display'] }} </td>
              <td>{{ $file['modified_value'] }} </td>
              <td>{{ $file['filesize'] }}</td>
              <td>

                  @can('superadmin')
                      <a data-html="false"
                         class="btn delete-asset btn-danger btn-sm {{ (config('app.lock_passwords')) ? ' disabled': '' }}" data-toggle="modal" href=" {{ route('settings.backups.destroy', $file['filename']) }}" data-content="{{ trans('admin/settings/message.backup.delete_confirm') }}" data-title="{{ trans('general.delete') }}  {{ htmlspecialchars($file['filename']) }} ?" onClick="return false;">
                          <i class="fas fa-trash icon-white" aria-hidden="true"></i>
                          <span class="sr-only">{{ trans('general.delete') }}</span>
                      </a>

                     <a data-html="false" 
                        href="{{ route('settings.backups.restore', $file['filename']) }}" class="btn btn-warning btn-sm restore-asset {{ (config('app.lock_passwords')) ? ' disabled': '' }}" data-toggle="modal" data-content="Yes, restore it. I acknowledge that this will overwrite any existing data currently in the database. This method does not currently support installations that use S3 for file storage." data-title="Are you sure you wish to restore your database from {{ $file['filename']}}?" onClick="return false;">
                      <i class="fas fa-retweet" aria-hidden="true"></i>
                      <span class="sr-only">Restore</span>
                    </a>
                     
                  @endcan
              </td>
            </tr>
            @endforeach
            </tbody>
          </table>
      </div> <!-- end table-responsive div -->
    </div> <!-- end box-body div -->
</div> <!-- end box div -->
</div> <!-- end col-md div -->

   <!-- side address column -->
  <div class="col-md-3">

     
      <p>Backup files are located in: <code>{{ $path  }}</code></p>

      <h2>Upload Backup</h2>

      
      <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
        <div class="col-md-12">
          
          {{ Form::open([
            'method' => 'POST',
            'route' => 'settings.backups.upload',
            'files' => true,
            'class' => 'form-horizontal' ]) }}

            @csrf

            <input type="file" id="file" name="file" aria-label="file" class="sr-only">
    
            <label class="btn btn-default" aria-hidden="true">
                {{ trans('button.select_file')  }}
                <input type="file" name="file" class="js-uploadFile" data-maxsize="{{ Helper::file_upload_max_size() }}" accept="application/zip" style="display:none; max-width: 90%" aria-label="file" aria-hidden="true">
            </label>
    
            <p class="help-block" id="uploadFile-status">{{ trans_choice('general.filetypes_accepted_help', 3, ['size' => Helper::file_upload_max_size_readable(), 'types' => '.zip']) }}</p>
            {!! $errors->first('file', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}

            <button>Submit</button>
          {{ Form::close() }}
          
        </div> <!-- end col-md-12 form div -->
   </div> <!-- end form group div -->

  </div> <!-- end col-md-3 div -->
</div> <!-- end row div -->

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop

