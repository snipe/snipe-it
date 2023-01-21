@extends('layouts/default')
@section('title')
    Receiving
    @parent
@stop

@section('content')
    <div class="row">
        <!-- col-md-8 -->
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">

            {{-- 
                
                 I had to deviate from the modal framework a little bit as I was not able to pass data to it through AJAX or other mean.
                 There might be some backend magic that I could work out later.    
                
            --}}

            @include('modals.serialnumber') {{-- This injects the serial number modal directly to the view instead of it being called through the modal framework 'api' --}}

            <form id="create-form" class="form-horizontal" autocomplete="off" role="form" enctype="multipart/form-data">

                <!-- box -->
                <div class="box box-default">
                    <!-- box-header -->
                    <div class="box-header with-border text-right">

                        <div class="col-md-12 box-title text-right" style="padding: 0px; margin: 0px;">

                            <div class="col-md-12" style="padding: 0px; margin: 0px;">
                                <div class="col-md-9 text-left">
                                    <h2>Receive Parts</h2>
                                </div>
                                <div class="col-md-3 text-right" style="padding-right: 10px;">
                                    <a class="btn btn-link text-left" href="{{ URL::previous() }}">
                                        {{ trans('button.cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check icon-white" aria-hidden="true"></i>
                                        Receive
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-header -->

                    <!-- box-body -->
                    <div class="box-body">

                        <div class="form-group">
                            <label for="receiveParts" class="col-md-3 control-label">Search</label>
                            <div class="col-md-7 required">

                                <input class="form-control" type="text" name="receiveParts" data-validation="required"
                                    id="receiveParts" autofocus/>

                            </div>
                            @php
                                $result = Session::get('model');
                            @endphp

                            <div class="col-md-1 col-sm-1 text-left">
                                <a href='{{ route('modal.show', 'model') }}' data-toggle="modal" data-target="#createModal"
                                    data-select='model_select_id'
                                    class="btn btn-sm btn-primary">{{ trans('button.new') }}</a>
                            </div>
                        </div>
                        <!-- CSRF Token -->
                        {{ csrf_field() }}
                        {{-- @yield('inputFields') --}}
                    </div>

                </div> <!-- ./box-body -->
            </form>
        </div> <!-- box -->
    </div> <!-- col-md-8 -->

    </div><!-- ./row -->
@stop

@section('moar_scripts')
    <script>
        /* 
                    Send request via AJAX.
                    This is to improve speed. Unfortunately, I haven't found a pretty way to handle warnings with the current notifaction framework without a lot of copy/pasta
                    Copy/pasta would just be ugly. May revist this later to make it a little less chatty with the server. The idea is to keep calls to the server down and minimize redirects.
                */

        let model_number;

        $("#create-form").submit((e) => {

            $.ajax({
                type: "get",
                url: "/productflow/show",
                data: {
                    receiveParts: $("#receiveParts").val()
                },
                success: (res) => {
                    if (res.status == "success" && (res.payload != undefined || res.payload != null)) {
                        model_number = res.payload.model_number
                        $("#model-info span").remove();
                        $("#model-info").append(`<span>${res.payload.name} ${model_number}</span>`)
                        $("#getSerial").modal('show');
                        $("#modelID").val(res.payload.id);
                        $("#model_number").val(model_number)
                        // console.dir(res)
                    } else {
                        window.location.href =
                            "/productflow/show?receiveParts=0" // Redirect with a known false value that will prompt the server to load our warning for us (ugly I know)
                    }
                },
                error: (err) => {
                    console.dir(err)
                }
            });
            e.preventDefault();
        });

        $("#serial-number-form").submit((e) => {
            let error_message = "Serial Number cannot be empty!";

            if ($("#modal-serial_number").val() == "") {
                $('#modal_error_msg').html(error_message).show();
                e.preventDefault();
            }

        });
        // Autofocus to the modal serial number field (less clicking = happier users)
        $("#getSerial").on('show.bs.modal', (e) => {
            setTimeout(() => {
                $("#modal-serial_number").focus()
            }, 300);
        });
    </script>
    @include ('partials.bootstrap-table')
@stop
