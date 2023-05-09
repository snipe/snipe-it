@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.reset') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-solid box-danger">
                <div class="box-header with-border">
                    <h1 class="box-title"><i class="fa-solid fa-house-fire" aria-hidden="true"></i> {{ trans('admin/settings/general.reset') }}</h1>
                </div>
                {{ Form::open(['method' => 'POST', 'files' => false, 'autocomplete' => 'off', 'class' => 'form-horizontal', 'role' => 'form' ]) }}
                <!-- CSRF Token -->
                {{csrf_field()}}
                <div class="box-body">
                    <div class="col-md-12">
                        <p>Select the tables you would like to empty from the list below. This generally should ONLY be needed if you have imported sample data and need to start again from "scratch".
                        </p>

                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle faa-pulse animated" aria-hidden="true"></i>
                            <strong>{{ trans('general.notification_warning') }}</strong>
                            It cannot be overstated enough that anything you do here is data-destructive and should be used with extreme caution.
                        </div>

                        <p>Unselectable tables will have corresponding table entries automatically removed.</p>

                        <div class="form-group">

                            @foreach ($tables as $table)
                                <div class="col-md-4">
                                    <label class="form-control{{ (!in_array($table, $only_tables)) ? ' form-control--disabled' : '' }}">
                                        <input name="{{ $table }}" value="{{ $table }}" type="checkbox"{{ (!in_array($table, $only_tables)) ? ' disabled' : '' }}>{{ str_replace('_', ' ', $table) }}
                                    </label>
                                </div>
                            @endforeach

                        </div>

                        <p>{{ trans('admin/settings/general.confirm_purge_help') }}</p>
                        <div class="col-md-3{{ $errors->has('confirm_purge') ? 'error' : '' }}">
                            {{ Form::label('confirm_purge', trans('admin/settings/general.confirm_purge')) }}
                        </div>
                        <div class="col-md-9{{ $errors->has('confirm_purge') ? 'error' : '' }}">
                            @if (config('app.lock_passwords')===true)
                                {{ Form::text('confirm_purge', Request::old('confirm_purge'), array('class' => 'form-control', 'disabled'=>'true')) }}
                            @else
                                {{ Form::text('confirm_purge', Request::old('confirm_purge'), array('class' => 'form-control')) }}
                            @endif

                            @if (config('app.lock_passwords')===true)
                                <p class="text-warning"><i class="fas fa-lock"></i> {{ trans('general.feature_disabled') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-danger" {{ (config('app.lock_passwords')===true) ? ' disabled' : '' }}>{{ trans('admin/settings/general.purge') }}</button>
                </div> <!--/box-footer-->
                {{ Form::close() }}
            </div> <!--/.box-solid-->
        </div><!-- /.col-md-8-->
    </div><!--/.row-->

    {{Form::close()}}

@stop
