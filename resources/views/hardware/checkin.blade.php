@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/hardware/general.checkin') }}
@parent
@stop

{{-- Page content --}}
@section('content')


<style>

.input-group {
    padding-left: 0px !important;
}
</style>


<div class="row">

<!-- left column -->
<div class="col-md-9">

  <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin/hardware/form.tag') }} {{ $asset->asset_tag }}</h3>
      </div><!-- /.box-header -->

      <div class="box-body">

        @if ($backto=='user')
        	<form class="form-horizontal" method="post" action="{{ route('checkin/hardware', array('assetId'=> $asset->id, 'backto'=>'user')) }}" autocomplete="off">
        @else
        	<form class="form-horizontal" method="post" action="{{ route('checkin/hardware', $asset->id) }}" autocomplete="off">
        @endif
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        @if ($asset->model->name)
          <!-- Asset name -->
          <div class="form-group">
            <div class="col-md-3">
              {{ Form::label('name', trans('admin/hardware/form.model')) }}
            </div>
            <div class="col-md-9">
              <p class="form-control-static">{{ $asset->model->name }}</p>
            </div>
          </div>
        @endif

        @if ($asset->name)
          <!-- Asset name -->
          <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
            <div class="col-md-3">
              {{ Form::label('name', trans('admin/hardware/form.name')) }}
            </div>
            <div class="col-md-9">
              <p class="form-control-static">{{ $asset->name }}</p>
            </div>
          </div>
        @endif

        <!-- Status -->
        <div class="form-group {{ $errors->has('status_id') ? 'error' : '' }}">
          <div class="col-md-3">
            {{ Form::label('name', trans('admin/hardware/form.name')) }}
          </div>
          <div class="col-md-9">
            {{ Form::select('status_id', $statusLabel_list, '', array('class'=>'select2', 'style'=>'width:350px','id' =>'modal-statuslabel_types')) }}
            {!! $errors->first('status_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>

        <!-- Checkout/Checkin Date -->

        <div class="form-group {{ $errors->has('checkin_at') ? 'error' : '' }}">
          <div class="col-md-3">
            {{ Form::label('name', trans('admin/hardware/form.checkin_date')) }}
          </div>
          <div class="col-md-9">
            <div class="col-md-4 input-group">
            <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Checkin Date" name="checkin_at" id="checkin_at" value="{{ Input::old('checkin_at', date('Y-m-d')) }}">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
          </div>
            {!! $errors->first('checkin_at', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>


        <!-- Note -->
        <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
          <div class="col-md-3">
            {{ Form::label('note', trans('admin/hardware/form.notes')) }}
          </div>
          <div class="col-md-9">
            <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', $asset->note) }}</textarea>
            {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>



      </div>
      <div class="box-footer">
        <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.checkin') }}</button>
      </div>
  </div>

</div>
</div>

@stop
