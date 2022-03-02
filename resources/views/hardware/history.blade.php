@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.import-history') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('hardware.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')


    @if (isset($status))

        @if (count($status['error']) > 0)
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-default">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle faa-pulse animated"></i>
                            <strong>{{ count($status['error']) }} {{ trans('admin/hardware/general.error_messages') }}</strong> </strong>
                            {{ trans('admin/hardware/general.alert_details') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-default">
                    <div class="alert alert-success">
                        <i class="fas fa-check faa-pulse animated"></i>
                        <strong>{{ count($status['success']) }} {{ trans('admin/hardware/general.success_messages') }} </strong>
                        {{ trans('admin/hardware/general.alert_details') }}
                    </div>
                </div>
            </div>
        </div>

        @endif

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-md-12">
                    <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        @if (Session::get('message'))
                            <p class="alert-danger">
                                {{ trans('admin/hardware/general.csv_error') }}<br />
                                {{ Session::get('message') }}
                            </p>
                        @endif

                        {!! trans('admin/hardware/general.import_text') !!}

                        <div class="form-group">
                            <label for="first_name" class="col-sm-3 control-label">{{ trans('admin/users/general.usercsv') }}</label>
                            <div class="col-sm-9">
                                <input type="file" name="user_import_csv" id="user_import_csv"{{ (config('app.lock_passwords')===true) ? ' disabled' : '' }}>
                                @if (config('app.lock_passwords')===true)
                                    <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                                @endif
                            </div>
                        </div>




                <!-- Match firstname.lastname -->
                <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        {{ Form::checkbox('match_firstnamelastname', '1', Request::old('match_firstnamelastname')) }} {{ trans('admin/hardware/general.csv_import_match_f-l') }}
                    </div>
                </div>

                <!-- Match flastname -->
                <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        {{ Form::checkbox('match_flastname', '1', Request::old('match_flastname')) }} {{ trans('admin/hardware/general.csv_import_match_initial_last') }}
                    </div>
                </div>

                <!-- Match firstname -->
                <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        {{ Form::checkbox('match_firstname', '1', Request::old('match_firstname')) }} {{ trans('admin/hardware/general.csv_import_match_first') }}
                    </div>
                </div>

                <!-- Match email -->
                <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        {{ Form::checkbox('match_email', '1', Request::old('match_email')) }} {{ trans('admin/hardware/general.csv_import_match_email') }}
                    </div>
                </div>

                 <!-- Match username -->
                <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-10">
                        {{ Form::checkbox('match_username', '1', Request::old('match_username')) }} {{ trans('admin/hardware/general.csv_import_match_username') }}
                    </div>
                </div>

               </div>



        </div>

    <!-- Form Actions -->
    <div class="box-footer text-right">
        @if (config('app.lock_passwords')===true)
            <div class="col-md-12">
                <div class="callout callout-info">
                    {{ trans('general.feature_disabled') }}
                </div>
            </div>

        @else
            <button type="submit" class="btn btn-default">{{ trans('button.submit') }}</button>
         @endif
    </div>

</form>

 </div>

            @if (isset($status))


                @if (count($status['error']) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h2 class="box-title"> {{ count($status['error']) }} {{ trans('admin/hardware/general.error_messages') }} </h2>
                            </div>
                            <div class="box-body">
                                <div style="height : 400px; overflow : auto;">
                                    <table class="table">
                                        @for ($x = 0; $x < count($status['error']); $x++)
                                            @foreach($status['error'][$x] as $object_type => $message)
                                            <tr class="danger">
                                                <td><strong>{{ ucwords($object_type)  }} {{ key($message)  }}:</strong></td>
                                                <td>{{ $message[key($message)]['msg']  }}</td>
                                            </tr>
                                            @endforeach
                                        @endfor
                                    </table>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif

                @if (count($status['success']) > 0)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h2 class="box-title"> {{ count($status['success']) }} {{ trans('admin/hardware/general.success_messages') }} </h2>
                                    </div>
                                    <div class="box-body">
                                        <div style="height : 400px; overflow : auto;">
                                            <table class="table">
                                                @for ($x = 0; $x < count($status['success']); $x++)
                                                    @foreach($status['success'][$x] as $object_type => $message)
                                                        <tr class="success">
                                                            <td><strong>{{ ucwords($object_type)  }} {{ key($message)  }}:</strong></td>
                                                            <td>{{ $message[key($message)]['msg']  }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endfor
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endif
            @endif

        </div></div></div>
<script nonce="{{ csrf_token() }}">
$(document).ready(function(){

    $('#generate-password').pGenerator({
        'bind': 'click',
        'passwordElement': '#password',
        'displayElement': '#password-display',
        'passwordLength': 10,
        'uppercase': true,
        'lowercase': true,
        'numbers':   true,
        'specialChars': false,

    });
});

</script>
@stop
