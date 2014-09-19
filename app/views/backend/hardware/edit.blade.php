@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($asset->id)
    	@lang('base.asset_update') ::
    @else
    	@lang('base.asset_create') ::
    @endif
@parent
@stop

{{-- Page content --}}

@section('content')

<form class="form-horizontal" method="post" action="" autocomplete="off" role="form">
    
<div class="row header">
    <div class="col-md-10">
            
            <button type="submit" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>            
            <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
            
        <h3>
        @if ($asset->id)
            @lang('base.asset_update')
        @elseif(isset($clone_asset))
            @lang('base.asset_clone')
        @else
            @lang('base.asset_create')
        @endif
        </h3>
            
    </div>                            
</div>

<div class="row form-wrapper">
            <!-- left column -->
            <div class="col-md-12 column">

            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Asset Tag -->
            <div class="form-group {{ $errors->has('asset_tag') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'asset_tag', Lang::get('general.asset_tag'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    <input class="form-control" type="text" name="asset_tag" id="asset_tag" value="{{{ Input::old('asset_tag', $asset->asset_tag) }}}" />
                    {{ $errors->first('asset_tag', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>

            <!-- Asset Title -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'name', Lang::get('general.name'), array('class' => 'col-md-2 control-label')); }} 
                
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $asset->name) }}}" />
                        {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>
            
            <!-- Model -->
            <div class="form-group {{ $errors->has('model_id') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'model_id', Lang::get('base.model'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    {{ Form::select('model_id', $model_list , Input::old('model_id', $asset->model_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('model_id', '&nbsp;<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>

            <!-- Serial -->
            <div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'serial', Lang::get('general.serialnumber'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    <input class="form-control" type="text" name="serial" id="serial" value="{{{ Input::old('serial', $asset->serial) }}}" />
                    {{ $errors->first('serial', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>
            
            <!-- Location -->
            <div class="form-group {{ $errors->has('location_id') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'location_id', Lang::get('base.location'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    {{ Form::select('location_id', $location_list , Input::old('location_id', $asset->location_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('location_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    
        		<!-- Strict Assignment -->
                        &nbsp;&nbsp;<label>
			<input type="checkbox" value="1" name="strict_assignment" id="strict_assignment" {{ Input::old('strict_assignment', $asset->strict_assignment) == '1' || empty($asset->id) ? ' checked="checked"' : '' }}> @lang('general.strict_assignment')
			</label>
                </div>
                <div class="checkbox">

		</div>
            </div>
                      
            <!-- Supplier -->
            <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'supplier_id', Lang::get('base.supplier'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    {{ Form::select('supplier_id', $supplier_list , Input::old('supplier_id', $asset->supplier_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('supplier_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>
            
            <!-- Service Agreement -->
            <div class="form-group {{ $errors->has('service_agreement_id') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'service_agreement_id', Lang::get('base.serviceagreement'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    {{ Form::select('service_agreement_id', $service_agreement_list , Input::old('service_agreement_id', $asset->service_agreement_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('service_agreement_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>

            <!-- Order Number -->
            <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'order_number', Lang::get('general.ordernumber'), array('class' => 'col-md-2 control-label')); }} 
                <div class="col-md-7">
                    <input class="form-control" type="text" name="order_number" id="order_number" value="{{{ Input::old('order_number', $asset->order_number) }}}" />
                    {{ $errors->first('order_number', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>

            <!-- Purchase Date -->
            <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'purchase_date', Lang::get('general.purchasedate'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="input-group col-md-2">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{{ Input::old('purchase_date', $asset->purchase_date) }}}">
                    <span class="input-group-addon"><i class="icon-calendar"></i></span>
                {{ $errors->first('purchase_date', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>
            
            <!-- Purchase Cost -->
            <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
                    {{ Form::label_for($asset, 'purchase_cost', Lang::get('general.purchasecost'), array('class' => 'col-md-2 control-label')); }} 
                
                    <div class="col-md-2">
                            <div class="input-group">
                                    <span class="input-group-addon">@lang('general.currency')</span>
                                    <input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', number_format($asset->purchase_cost,2,'.','')) }}" />
                             </div>
                     </div>
                    {{ $errors->first('purchase_cost', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
            </div>
 
            <!-- Warrantee -->
            <div class="form-group {{ $errors->has('warranty_months') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'warranty_months', Lang::get('admin/hardware/form.warranty'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-2">
                    <div class="input-group">
                    <input class="col-md-2 form-control" type="text" name="warranty_months" id="warranty_months" value="{{{ Input::old('warranty_months', $asset->warranty_months) }}}" />
                    <span class="input-group-addon">@lang('general.months')</span>
                    </div>
                </div>
                {{ $errors->first('warranty_months', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
            </div>

            <!-- Status -->
            <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'status_id', Lang::get('base.statuslabel'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                        {{ $asset->state->getSelect() }}                        
                        {{ $errors->first('status_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                        
                <!-- Requestable -->            
                        &nbsp;&nbsp;
                        <label>
				<input type="checkbox" value="1" name="requestable" id="requestable" {{ Input::old('requestable', $asset->requestable) == '1' || empty($asset->id) ? ' checked="checked"' : '' }}> @lang('admin/hardware/form.requestable')
			</label>
                    </div>
            </div>
            
            @if (!$asset->id)
             <!-- Assigned To   // REMOVED due to logic concerns - next version!
            <div class="form-group {{ $errors->has('assigned_to') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'assigned_to', Lang::get('admin/hardware/form.checkout_to'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    {{ Form::select('assigned_to', $assigned_to , Input::old('assigned_to', $asset->assigned_to), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    <p class="help-block">@lang('admin/hardware/form.help_checkout')</p>
                    {{ $errors->first('assigned_to', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>
             -->
            @endif

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                {{ Form::label_for($asset, 'notes', Lang::get('general.notes'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    <textarea class="col-md-6 form-control" type="text" name="notes" id="notes">{{{ Input::old('notes', $asset->notes) }}}</textarea>
                    {{ $errors->first('notes', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>
            
            <!-- Form actions -->
                <div class="form-group">
                    <br>
                <label class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <a href="{{ URL::previous() }}" class="btn btn-default"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>
                    </div>
                </div>

    </div>
</div>
    
</form>

@stop
