@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Purge Deleted
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
                    <h3 class="box-title"><i class="fa fa-warning"></i> {{ trans('admin/settings/general.purge') }}</h3>
                </div>
            {{ Form::open(['method' => 'POST', 'files' => false, 'autocomplete' => 'off', 'class' => 'form-horizontal', 'role' => 'form' ]) }}
            <!-- CSRF Token -->
                {{csrf_field()}}
                <div class="box-body">
                    <p>{{ trans('admin/settings/general.confirm_purge_help') }}</p>
                    <div class="col-md-3{{ $errors->has('confirm_purge') ? 'error' : '' }}">
                        {{ Form::label('confirm_purge', trans('admin/settings/general.confirm_purge')) }}
                    </div>
                    <div class="col-md-9{{ $errors->has('confirm_purge') ? 'error' : '' }}">
                        @if (config('app.lock_passwords')===true)
                            {{ Form::text('confirm_purge', Input::old('confirm_purge'), array('class' => 'form-control', 'disabled'=>'disabled')) }}
                        @else
                            {{ Form::text('confirm_purge', Input::old('confirm_purge'), array('class' => 'form-control')) }}
                        @endif
                        {!! $errors->first('ldap_version', '<span class="alert-msg">:message</span>') !!}
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-danger">{{ trans('admin/settings/general.purge') }}</button>
                </div> <!--/box-footer-->
                {{ Form::close() }}
            </div> <!--/.box-solid-->
        </div><!-- /.col-md-8-->
    </div><!--/.row-->

    {{Form::close()}}

@stop
