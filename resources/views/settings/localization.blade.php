@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.localization_title') }}
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
                        <i class="fas fa-globe-americas" aria-hidden="true"></i> {{ trans('admin/settings/general.localization') }}
                    </h2>
                </div>
                <div class="box-body">


                    <div class="col-md-11 col-md-offset-1">

                        <!-- Language -->
                        <div class="form-group {{ $errors->has('site_name') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('site_name', trans('admin/settings/general.default_language')) }}
                            </div>
                            <div class="col-md-9">
                                {!! Form::locales('locale', Request::old('locale', $setting->locale), 'select2') !!}

                                {!! $errors->first('locale', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Date format -->
                        <div class="form-group {{ $errors->has('time_display_format') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('time_display_format', trans('general.time_and_date_display')) }}
                            </div>
                            <div class="col-md-9">
                                {!! Form::date_display_format('date_display_format', Request::old('date_display_format', $setting->date_display_format), 'select2') !!}

                                {!! Form::time_display_format('time_display_format', Request::old('time_display_format', $setting->time_display_format), 'select2') !!}

                                {!! $errors->first('time_display_format', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Currency -->
                        <div class="form-group {{ $errors->has('default_currency') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('default_currency', trans('admin/settings/general.default_currency')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('default_currency', old('default_currency', $setting->default_currency), array('class' => 'form-control select2-container','placeholder' => 'USD', 'maxlength'=>'3', 'style'=>'width: 60px; display: inline-block; ')) }}

                                {!! Form::digit_separator('digit_separator', old('digit_separator', $setting->digit_separator), 'select2') !!}

                                {!! $errors->first('default_currency', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>





                    </div>

                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}

@stop

