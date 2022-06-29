@extends('layouts/default')

{{-- Page title --}}
@section('title')
Some title here
@parent
@stop

@section('header_right')
    <a href="#" class="btn btn-primary text-right" style="margin-right: 10px;">{{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs hidden-print">

        <li class="active">
          <a href="#details" data-toggle="tab">
            <span class="hidden-lg hidden-md">
                <i class="fas fa-info-circle fa-2x"></i>
            </span>
            <span class="hidden-xs hidden-sm">Active Tab</span>
          </a>
        </li>

        <li>
          <a href="#tab2" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fas fa-barcode fa-2x" aria-hidden="true"></i>
            </span>
            <span class="hidden-xs hidden-sm">
                Other Tab
                <badge class="badge badge-secondary">10</badge>
            </span>
          </a>
        </li>

        @can('update', \App\Models\User::class)
          <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal">
              <span class="hidden-xs"><i class="fas fa-paperclip" aria-hidden="true"></i></span>
              <span class="hidden-lg hidden-md hidden-xl"><i class="fas fa-paperclip fa-2x" aria-hidden="true"></i></span>
              <span class="hidden-xs hidden-sm">{{ trans('button.upload') }}</span>
              </a>
          </li>
        @endcan
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="details">
          <div class="row">

            <!-- Start button column -->
            <div class="col-md-3 col-xs-12 col-md-push-9 col-sm-push-9">


              <div class="col-md-12 text-center">
                <img src="{{ Auth::user()->present()->gravatar() }}"  class=" img-thumbnail hidden-print img-responsive" style="margin-bottom: 20px;" alt="Useful alt text here">
               </div>

                <div class="col-md-12" style="padding-bottom: 5px;">
                  <a href="#" style="width: 100%;" class="btn btn-sm btn-default hidden-print">A Button</a>
                </div>
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <a href="#" style="width: 100%;" class="btn btn-sm btn-primary hidden-print">Another Button</a>
                </div>
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <a href="#" style="width: 100%;" class="btn btn-sm btn-warning hidden-print">Another Button</a>
                </div>
                <div class="col-md-12" style="padding-bottom: 5px;">
                    <a href="#" style="width: 100%;" class="btn btn-sm btn-danger hidden-print">Another Button</a>
                </div>

            </div>


                <div class="col-md-9 col-xs-12 col-sm-pull-3 col-xs-pull-3">
                    <div class="row">
                        <div class="container row-new-striped">

                            <!-- name row -->
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    Name
                                </div>
                                <div class="col-md-9 col-xs-6">
                                    Value
                                </div>
                            </div><!-- /.row -->
                            <!-- end name -->

                            <!-- name row -->
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    Another Name
                                </div>
                                <div class="col-md-9 col-xs-6">
                                    Another Value
                                </div>
                            </div><!-- /.row -->
                            <!-- end name -->

                            <!-- longer text row -->
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    Longer Text
                                </div>
                                <div class="col-md-9 col-xs-6">
                                    <p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit amet consectetur adipisci[ng] velit, sed quia non numquam [do] eius modi tempora inci[di]dunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur?</p>
                                </div>
                            </div><!-- /.row -->
                            <!-- longer text row -->

                        </div><!-- /.container .row-striped -->
                    </div>


                </div> <!-- /.col-md-9 -->



          </div> <!--/.row-->
        </div><!-- /.tab-pane -->

        <div class="tab-pane" id="tab2">
          <!-- assets table -->

            @include('partials.asset-bulk-actions')
            @include('partials.tables.assets-listing', ['export_slug' => 'foo'])

        </div><!-- /tab-pane -->



      </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->
  </div>
</div>


@include ('modals.upload-file', ['item_type' => 'user', 'item_id' => ''])


@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table', ['simple_view' => true])
<script nonce="{{ csrf_token() }}">
$(function () {


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

            if (data && data.jqXHR && data.jqXHR.responseJSON && data.jqXHR.responseJSON.status === "error") {
                var errorMessage = data.jqXHR.responseJSON.messages["file.0"];
                $('#progress-bar-text').html(errorMessage[0]);
                $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-danger').css('width','100%');
                $('.progress-checkmark').fadeIn('fast').html('<i class="fas fa-times fa-3x icon-white" style="color: #d9534f"></i>');
            } else {
                $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-success').css('width','100%');
                $('.progress-checkmark').fadeIn('fast');
                $('#progress-container').delay(950).css('visibility', 'visible');
                $('.progress-bar-text').html('Finished!');
                $('.progress-checkmark').fadeIn('fast').html('<i class="fas fa-check fa-3x icon-white" style="color: green"></i>');
                $.each(data.result, function (index, file) {
                    $('<tr><td>' + file.note + '</td><<td>' + file.filename + '</td></tr>').prependTo("#files-table > tbody");
                });
            }
            $('#progress').removeClass('active');


        }
    });
});
</script>


@stop
