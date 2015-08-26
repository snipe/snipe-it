@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
     @lang('admin/hardware/general.checkout') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right">
        <i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
        <h3> @lang('admin/hardware/general.checkout')</h3>
    </div>
</div>

<div class="row form-wrapper">
<!-- left column -->
<div class="col-md-10 column">

<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Asset tag -->
            <div class="form-group">
            <label class="col-sm-2 control-label">@lang('admin/hardware/form.tag')</label>
                <div class="col-md-6">
                  <p class="form-control-static">{{{ $asset->asset_tag }}}</p>
                </div>
            </div>



            <!-- Asset Name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('admin/hardware/form.name')</label>
                    <div class="col-md-7 col-sm-12">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $asset->name) }}}" />
                        {{ $errors->first('name', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>


            @if ($asset->model->name)
            <!-- Asset name -->
            <div class="form-group">
            <label class="col-sm-2 control-label">@lang('admin/hardware/form.model')</label>
                <div class="col-md-6">
                  <p class="form-control-static">{{{ $asset->model->name }}}</p>
                </div>
            </div>
            @endif


            <!-- User -->

            <div class="form-group {{ $errors->has('assigned_to') ? ' has-error' : '' }}">
                <label for="assigned_to" class="col-md-2 control-label">@lang('admin/hardware/form.checkout_to')
                 <i class='fa fa-asterisk'></i></label>
                <div class="col-md-9">
                    {{ Form::select('assigned_to', $users_list , Input::old('assigned_to', $asset->assigned_to), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('assigned_to', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

			<!-- Checkout/Checkin Date -->
            <div class="form-group {{ $errors->has('checkout_at') ? ' has-error' : '' }}">
                <label for="checkout_at" class="col-md-2 control-label">@lang('admin/hardware/form.checkout_date')</label>
                <div class="input-group col-md-3">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Checkout Date" name="checkout_at" id="checkout_at" value="{{{ Input::old('checkout_at', date('Y-m-d')) }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                </div>
                {{ $errors->first('checkout_at', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
            </div>

            <!-- Expected Checkin Date -->
            <div class="form-group {{ $errors->has('expected_checkin') ? ' has-error' : '' }}">
                <label for="checkout_at" class="col-md-2 control-label">@lang('admin/hardware/form.expected_checkin')</label>
                <div class="input-group col-md-3">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Expected Checkin Date" name="expected_checkin" id="expected_checkin" value="{{{ Input::old('expected_checkin') }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ $errors->first('expected_checkin', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
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

            @if ($asset->requireAcceptance())
			<div class="form-group">
                <div class="col-md-9 col-md-offset-2">
                  <p class="hint-block">@lang('admin/categories/general.required_acceptance')</p>
                </div>
            </div>
            @endif


            @if ($asset->getEula())
            <div class="form-group">

                <div class="col-md-9 col-md-offset-2">
                  <p class="hint-block">@lang('admin/categories/general.required_eula')</p>
                </div>
            </div>
			@endif

            <!-- Form actions -->
            <div class="form-group">
            <label class="col-md-2 control-label"></label>
                <div class="col-md-7">
                    <a class="btn btn-link" href="{{ URL::previous() }}"> @lang('button.cancel')</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
                </div>
            </div>



</form>

</div>
</div>
@stop
