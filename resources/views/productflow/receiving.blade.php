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

            {{-- This injects the serial number & accessory modals directly to the view instead of it being called through the modal framework 'api' --}}
            @include('modals.serialnumber')
            @include('modals.accessory')
            @include('modals.button-dropdown')

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
                                    <button id="receiveBtn" type="submit" class="btn btn-primary" disabled="true">
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
                                    id="receiveParts" autofocus />

                            </div>
                            @php
                                $result = Session::get('model');
                            @endphp

                            <div class="col-md-1 col-sm-1 text-left">
                                <a data-toggle="modal" class="btn btn-sm btn-primary" id="newInventoryBtn">New</a>
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
            May revist this later to make it a little less chatty with the server. The idea is to keep calls to the server down and minimize redirects.
        */

        $("#newInventoryBtn").on('click', () => {
            $("#buttonDropdown").modal('show');
        });

        $("#newAsset").on('click', () => {
            $("#buttonDropdown").modal('hide');
        });
        $("#receiveParts").on('input', () => {
            $("#receiveParts").val() == "" ? $("#receiveBtn").attr('disabled', true) : $("#receiveBtn").attr('disabled', false);
        });

        $("#create-form").submit((e) => {
            let asset = (data) => {
                let model_number = data.payload.model_number;
                $("#model-info span").remove();
                $("#model-info").append(`<span>${data.payload.name} ${model_number}</span>`)
                $("#getSerial").modal('show');
                $("#modelID").val(data.payload.id);
                $("#model_number").val(model_number)
            }

            let accessory = (data) => {
                let model_number = data.payload.model_number;
                $("#accessory-info span").remove();
                $("#accessory-info").append(`<span>${data.payload.name} ${model_number}</span>`)
                $("#accessoryQTY").modal('show');
                $("#accessory-id").val(data.payload.id);
                $("#accessory-model_number").val(model_number);
            }

            if ($("#receiveParts").val() != null && $("#receiveParts").val() != "") {
                $.ajax({
                    type: "get",
                    url: "/productflow/show",
                    data: {
                        receiveParts: $("#receiveParts").val()
                    },
                    success: (res) => {

                        if (res.status == "success" && (res.payload != undefined || res.payload !=
                                null)) {
                            (res.messages == "asset") ? asset(res): accessory(res);

                            console.dir(res)
                        } else {
                            // Redirect with a known false value that will prompt the server to load our warning for us (ugly I know)
                            window.location.href = "/productflow/show?receiveParts=0"
                        }
                    },
                    error: (err) => {
                        console.dir(err)
                    }
                });
                e.preventDefault();
            }

        });

        $("#serial-number-form").submit((e) => {
            let error_message = "Serial Number cannot be empty!";

            if ($("#modal-serial_number").val() == "") {
                $('#modal_error_msg').html(error_message).slideDown("fast");
                e.preventDefault();
            }

        });

        $("#accessory-form").submit((e) => {
            let error_message = "QTY cannot be empty!";

            if ($("#modal-accessory_qty").val() == "") {
                $('#accessory_modal_error_msg').html(error_message).slideDown("fast");
                e.preventDefault();
            }

        });
        // Autofocus to the modal field (less clicking = happier users)
        $("#getSerial").on('show.bs.modal', (e) => {
            $("#modal-serial_number").val("")
            setTimeout(() => {
                $("#modal-serial_number").focus()
            }, 300);
        });
        $("#accessoryQTY").on('show.bs.modal', (e) => {
            setTimeout(() => {
                $("#modal-accessory_qty").focus()
            }, 300);
        });

        $("#getSerial").on('hide.bs.modal', (e) => {
            $("#receiveParts").focus();
            $("#modal_error_msg").slideUp("fast");
        });
        $("#accessoryQTY").on('hide.bs.modal', (e) => {
            $("#receiveParts").focus();
            $("#accessory_modal_error_msg").slideUp("fast");
        });
    </script>
    @include ('partials.bootstrap-table')
@stop
