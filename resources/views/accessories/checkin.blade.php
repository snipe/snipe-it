@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/accessories/general.checkin') }}
@parent
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')



    <div class="row">
        <div class="col-md-9">
            <form class="form-horizontal" method="post" action="" autocomplete="off">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="box box-default">
                    @if ($accessory->id)
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ $accessory->name }}</h3>
                        </div><!-- /.box-header -->
                    @endif

                    <div class="box-body">

                        <form class="form-horizontal" method="post" action="" autocomplete="off">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                    @if ($accessory->name)
                                    <!-- accessory name -->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">{{ trans('admin/hardware/form.name') }}</label>
                                        <div class="col-md-6">
                                          <p class="form-control-static">{{ $accessory->name }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Note -->
                                    <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                                        <label for="note" class="col-md-2 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                                        <div class="col-md-7">
                                            <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $accessory->note) }}</textarea>
                                            {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                                        </div>
                                    </div>
                              </div>
                        <div class="box-footer">
                            <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i>
                                {{ trans('general.checkin') }}</button>
                        </div>
                </div> <!-- .box.box-default -->
            </form>
        </div> <!-- .col-md-9-->
    </div> <!-- .row -->
@stop
