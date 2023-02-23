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
        <div class="col-md-7">
            <form class="form-horizontal" method="post" action="" autocomplete="off">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="box box-default">
                    @if ($accessory->id)
                        <div class="box-header with-border">
                            <h2 class="box-title">{{ $accessory->name }}</h2>
                        </div><!-- /.box-header -->
                    @endif

                            <div class="box-body">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                    @if ($accessory->name)
                                    <!-- accessory name -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{ trans('admin/hardware/form.name') }}</label>
                                        <div class="col-md-6">
                                          <p class="form-control-static">{{ $accessory->name }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Note -->
                                    <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                                        <label for="note" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                                        <div class="col-md-7">
                                            <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note', $accessory->note) }}</textarea>
                                            {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                        </div>
                                    </div>
                            <!-- Checkout/Checkin Date -->
                            <div class="form-group{{ $errors->has('checkin_at') ? ' has-error' : '' }}">
                                {{ Form::label('checkin_at', trans('admin/hardware/form.checkin_date'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-7">
                                    <div class="input-group col-md-5 required" style="padding-left: 0px;">
                                        <div class="input-group date" data-date-clear-btn="true" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-end-date="0d" data-autoclose="true">
                                            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="checkin_at" id="checkin_at" value="{{ Request::old('checkin_at', date('Y-m-d')) }}">
                                            <span class="input-group-addon"><i class="fas fa-calendar"></i></span>
                                        </div>
                                        {!! $errors->first('checkin_at', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
                                    </div>
                                </div>
                            </div>

                              </div>
                        <div class="box-footer">
                            <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
                            <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i>
                                {{ trans('general.checkin') }}</button>
                        </div>


                </div> <!-- .box.box-default -->
            </form>
        </div> <!-- .col-md-9-->
    </div> <!-- .row -->
@stop
