@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
     @lang('admin/hardware/general.checkin') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
        <h3> @lang('admin/hardware/general.checkin')</h3>
    </div>
</div>

<div class="row form-wrapper">
<!-- left column -->
<div class="col-md-10 column">
@if ($backto=='user')
	<form class="form-horizontal" method="post" action="{{ route('checkin/hardware', array('assetId'=> $asset->id, 'backto'=>'user')) }}" autocomplete="off">
@else
	<form class="form-horizontal" method="post" action="{{ route('checkin/hardware', $asset->id) }}" autocomplete="off">
@endif

    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Asset tag -->
            <div class="form-group">
            <label class="col-sm-2 control-label">@lang('admin/hardware/form.tag')</label>
                <div class="col-md-6">
                  <p class="form-control-static">{{{ $asset->asset_tag }}}</p>
                </div>
            </div>

			      @if ($asset->name)
            <!-- Asset name -->
            <div class="form-group">
            <label class="col-sm-2 control-label">@lang('admin/hardware/form.name')</label>
                <div class="col-md-6">
                  <p class="form-control-static">{{{ $asset->name }}}</p>
                </div>
            </div>
            @endif

            <div class="form-group">
              <div class="col-md-2 col-xs-12"><label for="status_id">@lang('admin/hardware/table.status'):
              </label></div>
              <div class="col-md-6 col-xs-12">{{ Form::select('status_id', $statusLabel_list, '', array('class'=>'select2', 'style'=>'width:350px','id' =>'modal-statuslabel_types')) }}</div>
            </div>

            <!-- Checkout/Checkin Date -->
            <div class="form-group {{ $errors->has('checkin_at') ? ' has-error' : '' }}">
                <label for="checkin_at" class="col-md-2 control-label">@lang('admin/hardware/form.checkin_date')</label>
                <div class="input-group col-md-3">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Checkin Date" name="checkin_at" id="checkin_at" value="{{{ Input::old('checkin_at', date('Y-m-d')) }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ $errors->first('checkin_at', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>


            <!-- Note -->
            <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                <label for="note" class="col-md-2 control-label">@lang('admin/hardware/form.notes')</label>
                <div class="col-md-7">
                    <textarea class="col-md-6 form-control" id="note" name="note">{{{ Input::old('note', $asset->note) }}}</textarea>
                    {{ $errors->first('note', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>
            <!-- Form actions -->
                <div class="form-group">
                <label class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <a class="btn btn-link" href="{{ URL::previous() }}">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i>@lang('general.checkin')</button>
                    </div>
                </div>

</form>
</div>
</div>

@stop
