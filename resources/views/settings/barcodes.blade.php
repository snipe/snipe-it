@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{  trans('admin/settings/general.barcode_title') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>


    {{ Form::open(['method' => 'POST', 'files' => false, 'autocomplete' => 'off', 'class' => 'form-horizontal', 'role' => 'form' ]) }}
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fas fa-barcode" aria-hidden="true"></i> {{ trans('admin/settings/general.barcodes') }}
                    </h2>
                </div>
                <div class="box-body">


                    <div class="col-md-11 col-md-offset-1">

                    @if ($is_gd_installed)
                        <!-- qr code -->
                            <div class="form-group">
                                <div class="col-md-3">
                                    {{ Form::label('qr_code', trans('admin/settings/general.display_qr')) }}
                                </div>
                                <div class="col-md-9">
                                    {{ Form::checkbox('qr_code', '1', old('qr_code', $setting->qr_code),array('class' => 'minimal', 'aria-label'=>'qr_code')) }}
                                    {{ trans('general.yes') }}
                                </div>
                            </div>

                            <!-- square barcode type -->
                            <div class="form-group{{ $errors->has('barcode_type') ? ' has-error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('barcode_type', trans('admin/settings/general.barcode_type')) }}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::barcode_types('barcode_type', old('barcode_type', $setting->barcode_type), 'select2 col-md-4') !!}
                                    {!! $errors->first('barcode_type', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                </div>
                            </div>

                            <!-- barcode -->
                            <div class="form-group">
                                <div class="col-md-3">
                                    {{ Form::label('alt_barcode_enabled', trans('admin/settings/general.display_alt_barcode')) }}
                                </div>
                                <div class="col-md-9">
                                    {{ Form::checkbox('alt_barcode_enabled', '1', old('alt_barcode_enabled', $setting->alt_barcode_enabled),array('class' => 'minimal', 'aria-label'=>'alt_barcode_enabled')) }}
                                    {{ trans('general.yes') }}
                                </div>
                            </div>

                            <!-- barcode type -->
                            <div class="form-group{{ $errors->has('alt_barcode') ? ' has-error' : '' }}">
                                <div class="col-md-3">
                                    {{ Form::label('alt_barcode', trans('admin/settings/general.alt_barcode_type')) }}
                                </div>
                                <div class="col-md-9">
                                    {!! Form::alt_barcode_types('alt_barcode', old('alt_barcode', $setting->alt_barcode), 'select2 col-md-4') !!}
                                    {!! $errors->first('barcode_type', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                </div>
                            </div>
                        @else
                            <span class="help-block col-md-offset-3 col-md-12">
                                {{ trans('admin/settings/general.php_gd_warning') }}
                                <br>
                                {{ trans('admin/settings/general.php_gd_info') }}
                  </span>
                    @endif

                    <!-- qr text -->
                        <div class="form-group {{ $errors->has('qr_text') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('qr_text', trans('admin/settings/general.qr_text')) }}
                            </div>
                            <div class="col-md-9">
                                @if ($setting->qr_code == 1)
                                    {{ Form::text('qr_text', Request::old('qr_text', $setting->qr_text), array('class' => 'form-control','placeholder' => 'Property of Your Company',
                                    'rel' => 'txtTooltip',
                                    'title' =>'Extra text that you would like to display on your labels. ',
                                    'data-toggle' =>'tooltip',
                                    'data-placement'=>'top')) }}
                                    {!! $errors->first('qr_text', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                @else
                                    {{ Form::text('qr_text', Request::old('qr_text', $setting->qr_text), array('class' => 'form-control', 'disabled'=>'disabled','placeholder' => 'Property of Your Company')) }}
                                    <p class="help-block">{{ trans('admin/settings/general.qr_help') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Nuke barcode cache -->
                        <div class="form-group">
                            <div class="col-md-3">
                                {{ Form::label('purge_barcodes', 'Purge Barcodes') }}
                            </div>
                            <div class="col-md-9" id="purgebarcodesrow">
                                <a class="btn btn-default btn-sm pull-left" id="purgebarcodes" style="margin-right: 10px;">
                                    {{ trans('admin/settings/general.barcode_delete_cache') }}</a>
                                <span id="purgebarcodesicon"></span>
                                <span id="purgebarcodesresult"></span>
                                <span id="purgebarcodesstatus"></span>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                <div id="purgebarcodesstatus-error" class="text-danger"></div>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                <p class="help-block">{{ trans('admin/settings/general.barcodes_help') }}</p>
                            </div>

                        </div>


                    </div>

                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}

@stop

@push('js')

    <script nonce="{{ csrf_token() }}">
        // Delete barcodes
        $("#purgebarcodes").click(function(){
            $("#purgebarcodesrow").removeClass('text-success');
            $("#purgebarcodesrow").removeClass('text-danger');
            $("#purgebarcodesicon").html('');
            $("#purgebarcodesstatus").html('');
            $('#purgebarcodesstatus-error').html('');
            $("#purgebarcodesicon").html('<i class="fas fa-spinner spin"></i> {{ trans('admin/settings/general.barcodes_spinner') }}');
            $.ajax({
                url: '{{ route('api.settings.purgebarcodes') }}',
                type: 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                dataType: 'json',

                success: function (data) {
                    console.dir(data);
                    $("#purgebarcodesicon").html('');
                    $("#purgebarcodesstatus").html('');
                    $('#purgebarcodesstatus-error').html('');
                    $("#purgebarcodesstatus").removeClass('text-danger');
                    $("#purgebarcodesstatus").addClass('text-success');
                    if (data.message) {
                        $("#purgebarcodesstatus").html('<i class="fas fa-check text-success"></i> ' + data.message);
                    }
                },

                error: function (data) {

                    $("#purgebarcodesicon").html('');
                    $("#purgebarcodesstatus").html('');
                    $('#purgebarcodesstatus-error').html('');
                    $("#purgebarcodesstatus").removeClass('text-success');
                    $("#purgebarcodesstatus").addClass('text-danger');
                    $("#purgebarcodesicon").html('<i class="fas fa-exclamation-triangle text-danger"></i>');
                    $('#purgebarcodesstatus').html('Files could not be deleted.');
                    if (data.responseJSON) {
                        $('#purgebarcodesstatus-error').html('Error: ' + data.responseJSON.messages);
                    } else {
                        console.dir(data);
                    }

                }


            });
        });

    </script>

@endpush
