@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.bulkaudit') }}
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
    {{ Form::open(['method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form', 'id' => 'audit-form' ]) }}
        <!-- left column -->
        <div class="col-md-6">
            <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"> {{ trans('general.bulkaudit') }} </h3>
                    </div>
                    <div class="box-body">
                    {{csrf_field()}}

                    <!-- Next Audit -->
                        <div class="form-group {{ $errors->has('asset_tag') ? 'error' : '' }}">
                            {{ Form::label('asset_tag', trans('general.asset_tag'), array('class' => 'col-md-3 control-label', 'id' => 'audit_tag')) }}
                            <div class="col-md-9">
                                <div class="input-group date col-md-5" data-date-format="yyyy-mm-dd">
                                    <input type="text" class="form-control" name="asset_tag" id="asset_tag" value="{{ Input::old('asset_tag') }}">

                                </div>
                                {!! $errors->first('asset_tag', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>



                        <!-- Locations -->
                    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])


                        <!-- Next Audit -->
                        <div class="form-group {{ $errors->has('next_audit_date') ? 'error' : '' }}">
                            {{ Form::label('next_audit_date', trans('general.next_audit_date'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-9">
                                <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <input type="text" class="form-control" placeholder="{{ trans('general.next_audit_date') }}" name="next_audit_date" id="next_audit_date" value="{{ Input::old('next_audit_date', $next_audit_date) }}">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                {!! $errors->first('next_audit_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>


                        <!-- Note -->
                        <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                            {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note') }}</textarea>
                                {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>



                    </div> <!--/.box-body-->
                    <div class="box-footer">
                        <a class="btn btn-link" href="{{ route('hardware.index') }}"> {{ trans('button.cancel') }}</a>
                        <button type="submit" id="audit_button" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.audit') }}</button>
                    </div>



            </div>



            {{Form::close()}}
        </div> <!--/.col-md-7-->
        <div class="col-md-6">
            <div class="box box-default" id="audited-div" style="display: none">
                <div class="box-header with-border">
                    <h3 class="box-title"> {{ trans('general.bulkaudit_status') }} (<span id="audit-counter">0</span> assets audited) </h3>
                </div>
                <div class="box-body">

                    <table id="audited" class="table table-striped snipe-table">
                        <thead>
                        <tr>
                            <th>{{ trans('general.asset_tag') }}</th>
                            <th>{{ trans('general.bulkaudit_status') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr id="audit-loader" style="display: none;">
                                <td colspan="3">
                                    <i class="fa fa-spinner spin" aria-hidden="true"></i> Processing...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>


@stop


@section('moar_scripts')
    <script nonce="{{ csrf_token() }}">

        $("#audit-form").submit(function (event) {
            $('#audited-div').show();
            $('#audit-loader').show();

            event.preventDefault();

            var form = $("#audit-form").get(0);
            var formData = $('#audit-form').serializeArray();

            $.ajax({
                url: "{{ route('api.asset.audit') }}",
                type : 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                dataType : 'json',
                data : formData,
                success : function (data) {
                    if (data.status == 'success') {
                        $('#audited tbody').append("<tr class='success'><td>" + data.payload.asset_tag + "</td><td>" + data.messages + "</td><td><i class='fa fa-check text-success'></i></td></tr>");
                        incrementOnSuccess();
                    } else {
                        handleAuditFail(data);
                    }
                    $('input#asset_tag').val('');
                },
                error: function (data) {
                    handleAuditFail(data);
                },
                complete: function() {
                    $('#audit-loader').hide();
                }

            });

            return false;
        });

        function handleAuditFail (data) {
            if (data.asset_tag) {
                var asset_tag = data.asset_tag;
            } else {
                var asset_tag = '';
            }
            if (data.messages) {
                var messages = data.messages;
            } else {
                var messages = '';
            }
            $('#audited tbody').append("<tr class='danger'><td>" + asset_tag + "</td><td>" + messages + "</td><td><i class='fa fa-times text-danger'></i></td></tr>");
        }

        function incrementOnSuccess() {
            var x = parseInt($('#audit-counter').html());
            y = x + 1;
            $('#audit-counter').html(y);
        }

        $("#audit_tag").focus();

    </script>
@stop
