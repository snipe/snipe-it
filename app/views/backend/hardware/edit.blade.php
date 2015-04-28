@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($asset->id)
    	@lang('admin/hardware/form.update') ::
    @else
    	@lang('admin/hardware/form.create') ::
    @endif
@parent
@stop

{{-- Page content --}}

@section('content')

<div class="row header">
    <div class="col-md-12">
            <a href="{{ URL::previous() }}" class="btn-flat gray pull-right right"><i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
        <h3>
        @if ($asset->id)
        	@lang('admin/hardware/form.update')
        @else
            @lang('admin/hardware/form.create')
        @endif
        </h3>
    </div>
</div>

<div class="row form-wrapper">
            <!-- left column -->
            <div class="col-md-12 column">

			 @if ($asset->id)
				 <form class="form-horizontal" method="post" action="{{ route('update/hardware',$asset->id) }}" autocomplete="off" role="form">
			 @else
				 <form class="form-horizontal" method="post" action="{{ route('savenew/hardware') }}" autocomplete="off" role="form">
			 @endif

            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Asset Tag -->
            <div class="form-group {{ $errors->has('asset_tag') ? ' has-error' : '' }}">
                <label for="asset_tag" class="col-md-2 control-label">@lang('admin/hardware/form.tag')
                 <i class='fa fa-asterisk'></i></label>
                 </label>
                    <div class="col-md-7">
                    	@if  ($asset->id)
							<input class="form-control" type="text" name="asset_tag" id="asset_tag" value="{{{ Input::old('asset_tag', $asset->asset_tag) }}}" />
						@else
							<input class="form-control" type="text" name="asset_tag" id="asset_tag" value="{{{ Input::old('asset_tag', Asset::autoincrement_asset()) }}}" />
						@endif

                        {{ $errors->first('asset_tag', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Serial -->
            <div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
                <label for="serial" class="col-md-2 control-label">@lang('admin/hardware/form.serial') <i class='fa fa-asterisk'></i></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="serial" id="serial" value="{{{ Input::old('serial', $asset->serial) }}}" />
                    {{ $errors->first('serial', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Asset Name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('admin/hardware/form.name')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $asset->name) }}}" />
                        {{ $errors->first('name', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Model -->
            <div class="form-group {{ $errors->has('model_id') ? ' has-error' : '' }}">
                <label for="parent" class="col-md-2 control-label">@lang('admin/hardware/form.model')
                 <i class='fa fa-asterisk'></i></label>
                 </label>
                <div class="col-md-7">
                    @if (isset($selected_model))
                        {{ Form::select('model_id', $model_list , $selected_model->id, array('class'=>'select2 model', 'style'=>'min-width:400px')) }}

                    @else
                        {{ Form::select('model_id', $model_list , Input::old('model_id', $asset->model_id), array('class'=>'select2 model', 'style'=>'min-width:400px')) }}
                    @endif
                    {{ $errors->first('model_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- MAC Address -->
            <div id="mac_address" class="form-group {{ $errors->has('mac_address') ? ' has-error' : '' }}" style="display:none;">
                <label for="mac_address" class="col-md-2 control-label">@lang('admin/hardware/form.mac_address')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="mac_address" id="mac_address" value="{{{ Input::old('mac_address', $asset->mac_address) }}}" />
                        {{ $errors->first('mac_address', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Purchase Date -->
            <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
                <label for="purchase_date" class="col-md-2 control-label">@lang('admin/hardware/form.date')</label>
                <div class="input-group col-md-3">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="@lang('general.select_date')" name="purchase_date" id="purchase_date" value="{{{ Input::old('purchase_date', $asset->purchase_date) }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ $errors->first('purchase_date', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Supplier -->
            <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                <label for="supplier_id" class="col-md-2 control-label">@lang('admin/hardware/form.supplier')</label>
                <div class="col-md-7">
                    {{ Form::select('supplier_id', $supplier_list , Input::old('supplier_id', $asset->supplier_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('supplier_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Order Number -->
            <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
                <label for="order_number" class="col-md-2 control-label">@lang('admin/hardware/form.order')</label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="order_number" id="order_number" value="{{{ Input::old('order_number', $asset->order_number) }}}" />
                    {{ $errors->first('order_number', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Purchase Cost -->
            <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
                    <label for="purchase_cost" class="col-md-2 control-label">@lang('admin/hardware/form.cost') </label>
                    <div class="col-md-2">
                            <div class="input-group">
                                    <span class="input-group-addon">@lang('general.currency')</span>
                                    <input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', number_format($asset->purchase_cost,2)) }}" />
                                    {{ $errors->first('purchase_cost', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                             </div>
                     </div>
            </div>

            <!-- Warranty -->
            <div class="form-group {{ $errors->has('warranty_months') ? ' has-error' : '' }}">
                <label for="warranty_months" class="col-md-2 control-label">@lang('admin/hardware/form.warranty')</label>
                <div class="col-md-2">
                    <div class="input-group">
                    <input class="col-md-2 form-control" type="text" name="warranty_months" id="warranty_months" value="{{{ Input::old('warranty_months', $asset->warranty_months) }}}" />   <span class="input-group-addon">@lang('admin/hardware/form.months')</span>
                    {{ $errors->first('warranty_months', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
                <label for="status_id" class="col-md-2 control-label">@lang('admin/hardware/form.status') <i class='fa fa-asterisk'></i></label>
                    <div class="col-md-7">
                        {{ Form::select('status_id', $statuslabel_list , Input::old('status_id', $asset->status_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                        {{ $errors->first('status_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-2 control-label">@lang('admin/hardware/form.notes')</label>
                <div class="col-md-7">
                    <textarea class="col-md-6 form-control" id="notes" name="notes">{{{ Input::old('notes', $asset->notes) }}}</textarea>
                    {{ $errors->first('notes', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Default Location -->
            <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
                <label for="status_id" class="col-md-2 control-label">@lang('admin/hardware/form.default_location')</label>
                    <div class="col-md-7">
                        {{ Form::select('rtd_location_id', $location_list , Input::old('rtd_location_id', $asset->rtd_location_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                        {{ $errors->first('status_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>


			@if (!$asset->id)
             <!-- Assigned To -->
            <div class="form-group {{ $errors->has('assigned_to') ? ' has-error' : '' }}">
                <label for="parent" class="col-md-2 control-label">@lang('admin/hardware/form.checkout_to')
                 </label>
                <div class="col-md-7">
                    {{ Form::select('assigned_to', $assigned_to , Input::old('assigned_to', $asset->assigned_to), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    <p class="help-block">@lang('admin/hardware/form.help_checkout')</p>
                    {{ $errors->first('assigned_to', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>
			@endif

			<!-- Requestable -->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				  <div class="checkbox">
					<label>
					  <input type="checkbox" value="1" name="requestable" id="requestable" {{ Input::old('requestable', $asset->requestable) == '1' ? ' checked="checked"' : '' }}> @lang('admin/hardware/form.requestable')
					</label>
				  </div>
				</div>
		  	</div>


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
<script>

	var $eventSelect = $(".model");
	$eventSelect.on("change", function () { mac_add($eventSelect.val()); });
	$(function() {
        var mac = $(".model option:selected").val();
        if(mac!=''){
	       mac_add(mac);
        }
	});
	function mac_add(id) {
	    $.ajax({
	        url: "{{Config::get('app.url')}}/api/models/"+id+"/check",
	        success: function(data) {
	            if(data == true){
	                 $("#mac_address").css("display", "block");
	            } else {
	                 $("#mac_address").css("display", "none");
	            }
	        }
	    });
	};
</script>

@stop
