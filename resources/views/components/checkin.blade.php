@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/licenses/general.checkin') }}
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
            <form class="form-horizontal" method="post" action="{{ route('component.checkin.save', $component_assets->id) }}" autocomplete="off">
                {{csrf_field()}}

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"> {{ $component->name }}</h3>
                    </div>
                    <div class="box-body">

                        <!-- Checked out to -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ trans('general.checkin_from') }}</label>
                            <div class="col-md-6">
                                <p class="form-control-static">{{ $asset->present()->fullName }}</p>
                            </div>
                        </div>


                        <!-- Qty -->
                        <div class="form-group {{ $errors->has('checkin_qty') ? 'error' : '' }}">
                            <label for="note" class="col-md-2 control-label">{{ trans('general.qty') }}</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="checkin_qty" value="{{ Input::old('assigned_qty', $component_assets->assigned_qty) }}">
                            </div>
                            <div class="col-md-9 col-md-offset-2">
                            <p class="help-block">Must be {{ $component_assets->assigned_qty }} or less.</p>
                            {!! $errors->first('checkin_qty', '<span class="alert-msg"><i class="fa fa-times"></i>
                            :message</span>') !!}
                            </div>
                        </div>

                        <!-- Note -->
                        <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                            <label for="note" class="col-md-2 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                            <div class="col-md-7">
                                <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $component->note) }}</textarea>
                                {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>
                        <div class="box-footer">
                            <a class="btn btn-link" href="{{ route('components.index') }}">{{ trans('button.cancel') }}</a>
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.checkin') }}</button>
                        </div>
                    </div> <!-- /.box-->
            </form>
        </div> <!-- /.col-md-7-->
    </div>


@stop
