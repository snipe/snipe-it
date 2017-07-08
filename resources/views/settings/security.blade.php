@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Update Security Settings
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>


    {{ Form::open(['method' => 'POST', 'files' => true, 'class' => 'form-horizontal', 'role' => 'form' ]) }}
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <i class="fa fa-lock"></i> Security
                    </h4>
                </div>
                <div class="box-body">


                    <div class="col-md-11 col-md-offset-1">

                        <!-- Two Factor -->
                        <div class="form-group {{ $errors->has('brand') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('two_factor_enabled', trans('admin/settings/general.two_factor_enabled_text')) }}
                            </div>
                            <div class="col-md-9">

                                {!! Form::two_factor_options('two_factor_enabled', Input::old('two_factor_enabled', $setting->two_factor_enabled), 'select2') !!}
                                <p class="help-block">{{ trans('admin/settings/general.two_factor_enabled_warning') }}</p>

                                @if (config('app.lock_passwords'))
                                    <p class="help-block">{{ trans('general.feature_disabled') }}</p>
                                @endif

                                {!! $errors->first('two_factor_enabled', '<span class="alert-msg">:message</span>') !!}
                            </div>
                        </div>


                    </div>

                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}

@stop
