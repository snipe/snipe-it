@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Import History
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
                            <i class="fa fa-exclamation-circle faa-pulse animated"></i>
                            <strong>{{ count($status['error']) }} Error Messagess: </strong>
                            Please see below for errors.
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-default">
                    <div class="alert alert-success">
                        <i class="fa fa-check faa-pulse animated"></i>
                        <strong>{{ count($status['success']) }} Success Messages: </strong>
                        Please see below for details.
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
                                    You have an error in your CSV file:<br />
                                    {{ Session::get('message') }}
                                </p>
                            @endif

                            <p>
                                Use this tool to import asset history you may have in CSV format. This information likely will be extracted from your previous asset management system.
                            </p>
                            <p>
                                <i>Asset history</i> is defined as a checkout and subsequent checkin that has happened in the past. The assets and users MUST already exist in SNIPE, or they will be skipped. Matching assets for history import happens against the asset tag.  We will try to find a matching user based on the user's full name you provide, based on the username format you configured in the Admin &gt; General Settings.
                            </p>

                            <p>
                                Fields included in the CSV must match <i>exactly</i> these header values: <strong>Asset Tag, Checkout Date, Checkin Date, Full Name</strong>. Any additional fields will be ignored.
                            </p>

                            <div class="form-group">
                                <label for="first_name" class="col-sm-3 control-label">{{ trans('admin/users/general.usercsv') }}</label>
                                <div class="col-sm-9">
                                    <input type="file" name="user_import_csv" id="user_import_csv"{{ (config('app.lock_passwords')===true) ? ' disabled' : '' }}>
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


                    @if (isset($status))


                        @if (count($status['error']) > 0)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"> {{ count($status['error']) }} Error Messages </h3>
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
                                                <h3 class="box-title"> {{ count($status['success']) }} Success Messages </h3>
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

                    </div>
                </div>
            </div>
        </div>
    </div>

            @stop
