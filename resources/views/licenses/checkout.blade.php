@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/licenses/general.checkout') }}
@parent
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
<div class="row">
        <!-- left column -->
    <div class="col-md-7">
        <form class="form-horizontal" method="post" action="" autocomplete="off">
            {{csrf_field()}}

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"> {{ $licenseSeat->license->name }}</h3>
                </div>
                <div class="box-body">

                    <!-- Asset name -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{ trans('admin/hardware/form.name') }}</label>
                        <div class="col-md-6">
                            <p class="form-control-static">{{ $licenseSeat->license->name }}</p>
                        </div>
                    </div>

                    <!-- Serial -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{ trans('admin/hardware/form.serial') }}</label>
                        <div class="col-md-10">
                            <p class="form-control-static" style="word-wrap: break-word;">{{ $licenseSeat->license->serial }}</p>
                        </div>
                    </div>

                    <!-- Asset -->
                    <div class="form-group {{ $errors->has('asset_id') ? ' has-error' : '' }}">
                        <label for="asset_id" class="col-md-2 control-label">{{ trans('admin/licenses/form.asset') }}
                         </label>

                        <div class="col-md-10">
                            {{ Form::select('asset_id', $asset_list , Input::old('asset_id', $licenseSeat->asset_id), array('class'=>'select2', 'style'=>'min-width:600px')) }}
                            {!! $errors->first('asset_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                    </div>

                    <!-- User -->
                    <div class="form-group {{ $errors->has('assigned_to') ? ' has-error' : '' }}">
                        <label for="assigned_to" class="col-md-2 control-label">{{ trans('admin/hardware/form.checkout_to') }}
                        </label>

                        <div class="col-md-9">
                            {{ Form::select('assigned_to', $users_list , Input::old('assigned_to', $licenseSeat->assigned_to), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                            {!! $errors->first('assigned_to', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}

                            <p class="help-block">
                            {{ trans('admin/licenses/form.checkout_help') }}
                            </p>
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                        <label for="note" class="col-md-2 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                        <div class="col-md-7">
                            <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $licenseSeat->note) }}</textarea>
                            {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <a class="btn btn-link" href="{{ route('licenses.index') }}">{{ trans('button.cancel') }}</a>
                    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.checkout') }}</button>
                </div>
            </div> <!-- /.box-->
        </form>
    </div> <!-- /.col-md-7-->
</div>

@stop
