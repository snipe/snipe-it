@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
     @lang('general.import') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
        <h3> @lang('general.import')</h3>
    </div>
</div>

<div class="row form-wrapper">

    <!-- left column -->
    <div class="col-md-12 column">

        <div class="col-md-3">
        <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-info fileinput-button">
                <i class="fa fa-plus icon-white"></i>
                <span>Select Import File...</span>
                <!-- The file input field used as target for the file upload widget -->
                <input id="fileupload" type="file" name="files[]" data-url="../api/hardware/import" accept="text/csv">
            </span>
        </div>
        <div class="col-md-9" id="progress-container" style="visibility: hidden; padding-bottom: 20px;">
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

        <script src="{{ asset('assets/js/jquery.ui.widget.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.iframe-transport.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.fileupload.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lib/jquery.fileupload.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lib/jquery.fileupload-ui.css') }}">


            <script>
            $(function () {
                //binds to onchange event of your input field
                var uploadedFileSize = 0;
                $('#fileupload').bind('change', function() {
                  uploadedFileSize = this.files[0].size;
                  $('#progress-container').css('visibility', 'visible');
                });

                $('.process').bind('click', function() {
                  $('.process').addClass('fa-spin');
                });

                $('#fileupload').fileupload({
                    //maxChunkSize: 100000,
                    dataType: 'json',
                    formData: {_token: '{{ csrf_token() }}'},
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
                            //console.log(data.jqXHR.responseJSON.error);
                        } else {
                            $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-success').css('width','100%');
                            $('.progress-checkmark').fadeIn('fast');
                            $('#progress-container').delay(950).css('visibility', 'visible');
                            $('.progress-bar-text').html('Finished!');
                            $('.progress-checkmark').fadeIn('fast').html('<i class="fa fa-check fa-3x icon-white" style="color: green"></i>');
                            $.each(data.result.files, function (index, file) {
                                $('<tr><td>' + file.name + '</td><td>Just now</td><td>' + file.filesize + '</td><td><a class="btn btn-info btn-sm" href="import/process/' + file.name + '"><i class="fa fa-spinner process"></i> Process</a></td></tr>').prependTo("#upload-table > tbody");
                                //$('<tr><td>').text(file.name).appendTo(document.body);
                            });
                        }
                        $('#progress').removeClass('active');


                    }
                });
            });
            </script>
    </div>
</div>



<table class="table table-hover" id="upload-table">
    <thead>
        <th>File</th>
        <th>Created</th>
        <th>Size</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($files as $file)
        <tr>
            <td>{{{ $file['filename'] }}}</td>
            <td>{{{ date("M d, Y g:i A", $file['modified']) }}} </td>
            <td>{{{ $file['filesize'] }}}</td>
            <td>
                <a class="btn btn-info btn-sm" href="import/process/{{{ $file['filename'] }}}">
                    <i class="fa fa-spinner process"></i> Process</a>

                <!-- <a data-html="false"
                class="btn delete-asset btn-danger btn-sm {{ (Config::get('app.lock_passwords')) ? ' disabled': '' }}" data-toggle="modal" href=" {{ route('assets/import/delete-file', $file['filename']) }}" data-content="@lang('admin/settings/message.backup.delete_confirm')" data-title="{{ Lang::get('general.delete') }}  {{ htmlspecialchars($file['filename']) }} ?" onClick="return false;">
                    <i class="fa fa-trash icon-white"></i>
                </a> -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@stop
