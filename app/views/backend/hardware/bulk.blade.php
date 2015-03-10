@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
        	@lang('admin/hardware/form.update') ::
    
@parent
@stop

{{-- Page content --}}

@section('content')

<div class="row header">
    <div class="col-md-12">
            <a href="{{ URL::previous() }}" class="btn-flat gray pull-right right"><i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
        <h3>

        	@lang('admin/hardware/form.bulk_update')
        </h3>
    </div>
</div>

<div class="row form-wrapper">
            <!-- left column -->
            <div class="col-md-12 column">
	                <p>@lang('admin/hardware/form.bulk_update_help')</p>
	                <p style="color: red"><strong><big>@lang('admin/hardware/form.bulk_update_warn', ['asset_count' => count($assets)])</big></strong></p>


			 <form class="form-horizontal" method="post" action="{{ route('hardware/bulksave') }}" autocomplete="off" role="form">
			

            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

           
            <!-- Purchase Date -->
            <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
                <label for="purchase_date" class="col-md-2 control-label">@lang('admin/hardware/form.date')</label>
                <div class="input-group col-md-3">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{{ Input::old('purchase_date') }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ $errors->first('purchase_date', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Status -->
            <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
                <label for="status_id" class="col-md-2 control-label">@lang('admin/hardware/form.status') <i class='fa fa-asterisk'></i></label>
                    <div class="col-md-7">
                        {{ Form::select('status_id', $statuslabel_list , Input::old('status_id'), array('class'=>'select2', 'style'=>'width:350px')) }}
                        {{ $errors->first('status_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Default Location -->
            <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
                <label for="status_id" class="col-md-2 control-label">@lang('admin/hardware/form.default_location')</label>
                    <div class="col-md-7">
                        {{ Form::select('rtd_location_id', $location_list , Input::old('rtd_location_id'), array('class'=>'select2', 'style'=>'width:350px')) }}
                        {{ $errors->first('status_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>
            
            @foreach ($assets as $key => $value)
            	<input type="hidden" name="bulk_edit[{{{ $key }}}]" value="1">  
            @endforeach
 

            <!-- Form actions -->
                <div class="form-group">
                <label class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <a class="btn btn-link" href="{{ URL::previous() }}">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
                    </div>
                </div>

        </form>
    </div>
</div>
@stop
