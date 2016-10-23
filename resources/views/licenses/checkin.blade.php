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



<div class="row form-wrapper">
<!-- left column -->
<div class="col-md-10 column">

@if ($backto=='user')
	<form class="form-horizontal" method="post" action="{{ route('checkin/license', array('licenseeat_id'=> $licenseseat->id, 'backto'=>'user')) }}" autocomplete="off">
@else
	<form class="form-horizontal" method="post" action="{{ route('checkin/license', $licenseseat->id) }}" autocomplete="off">
@endif

    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />


            <!-- Asset name -->
            <div class="form-group">
            <label class="col-sm-2 control-label">{{ trans('admin/hardware/form.name') }}</label>
                <div class="col-md-6">
                  <p class="form-control-static">{{ $licenseseat->license->name }}</p>
                </div>
            </div>

            <!-- Serial -->
            <div class="form-group">
            <label class="col-sm-2 control-label">{{ trans('admin/hardware/form.serial') }}</label>
                <div class="col-md-6">
                  <p class="form-control-static">{{ $licenseseat->license->serial }}</p>
                </div>
            </div>

            <!-- Note -->
            <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                <label for="note" class="col-md-2 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                <div class="col-md-7">
                    <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $licenseseat->note) }}</textarea>
                    {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                </div>
            </div>
            <!-- Form actions -->
                <div class="form-group">
                <label class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <a class="btn btn-link" href="{{ route('licenses') }}">{{ trans('button.cancel') }}</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.checkin') }}</button>
                    </div>
                </div>


</form>
</div>
</div>

@stop
