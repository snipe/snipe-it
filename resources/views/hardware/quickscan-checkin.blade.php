@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.quickscan_checkin') }}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <style>

        .input-group {
            padding-left: 0px !important;
        }
    </style>

    

    <div class="row">
    {{ Form::open(['method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'checkin-form' ]) }}
        <!-- left column -->
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title"> {{ trans('admin/hardware/general.bulk_checkin') }} </h2>
                </div>
                <div class="box-body">
                    {{csrf_field()}}

                    <!-- Asset Tag -->
                    <div class="form-group {{ $errors->has('asset_tag') ? 'error' : '' }}">
                        {{ Form::label('asset_tag', trans('general.asset_tag'), array('class' => 'col-md-3 control-label', 'id' => 'checkin_tag')) }}
                        <div class="col-md-9">
                            <div class="input-group date col-md-5" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control" name="asset_tag" id="asset_tag" value="{{ Request::old('asset_tag') }}">

                            </div>
                            {!! $errors->first('asset_tag', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>
    
                    <!-- Locations -->
                    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])

                    <!-- Note -->
                        <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                            {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note') }}</textarea>
                                {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>
    
    

                </div> <!--/.box-body-->
                <div class="box-footer">
                    <a class="btn btn-link" href="{{ route('hardware.index') }}"> {{ trans('button.cancel') }}</a>
                    <button type="submit" id="checkin_button" class="btn btn-success pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkin') }}</button>
                </div>



            </div>



            {{Form::close()}}
        </div> <!--/.col-md-6-->

        <div class="col-md-6">
            <div class="box box-default" id="checkedin-div" style="display: none">
                <div class="box-header with-border">
                    <h2 class="box-title"> {{ trans('general.quickscan_checkin_status') }} (<span id="checkin-counter">0</span> {{ trans('general.assets_checked_in_count') }}) </h2>
                </div>
                <div class="box-body">
    
                    <table id="checkedin" class="table table-striped snipe-table">
                        <thead>
                        <tr>
                            <th>{{ trans('general.asset_tag') }}</th>
                            <th>{{ trans('general.quickscan_checkin_status') }}</th>
                            <th></th>
                        </tr>
                        <tr id="checkin-loader" style="display: none;">
                            <td colspan="3">
                                <i class="fas fa-spinner spin" aria-hidden="true"></i> {{ trans('general.processing') }}...
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


@stop


@section('moar_scripts')
    <script nonce="{{ csrf_token() }}">

        $("#checkin-form").submit(function (event) {
            $('#checkedin-div').show();
            $('#checkin-loader').show();

            event.preventDefault();

            var form = $("#checkin-form").get(0);
            var formData = $('#checkin-form').serializeArray();

            $.ajax({
                url: "{{ route('api.asset.checkinbytag') }}",
                type : 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                dataType : 'json',
                data : formData,
                success : function (data) {
                    if (data.status == 'success') {
                        $('#checkedin tbody').prepend("<tr class='success'><td>" + data.payload.asset + "</td><td>" + data.messages + "</td><td><i class='fas fa-check text-success'></i></td></tr>");
                        incrementOnSuccess();
                    } else {
                        handlecheckinFail(data);
                    }
                    $('input#asset_tag').val('');
                },
                error: function (data) {
                    handlecheckinFail(data);
                },
                complete: function() {
                    $('#checkin-loader').hide();
                }

            });

            return false;
        });

        function handlecheckinFail (data) {
            if (data.payload.asset) {
                var asset = data.payload.asset;
            } else {
                var asset = '';
            }
            if (data.messages) {
                var messages = data.messages;
            } else {
                var messages = '';
            }
            $('#checkedin tbody').prepend("<tr class='danger'><td>" + asset + "</td><td>" + messages + "</td><td><i class='fas fa-times text-danger'></i></td></tr>");
        }

        function incrementOnSuccess() {
            var x = parseInt($('#checkin-counter').html());
            y = x + 1;
            $('#checkin-counter').html(y);
        }

        $("#checkin_tag").focus();

    </script>
@stop
