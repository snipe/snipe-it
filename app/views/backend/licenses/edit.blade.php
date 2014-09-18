@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($license->id)
        @lang('base.license_update') ::
    @else
        @lang('base.license_create') ::
    @endif
@parent
@stop

{{-- Page content --}}

@section('content')

<form class="form-horizontal" method="post" action="" autocomplete="off">
    
<div class="row header">
    <div class="col-md-10">
            
        <button type="submit" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>            
        <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
            
        <h3>
        @if ($license->id)
            @lang('base.license_update')
        @elseif(isset($clone_license))
            @lang('base.license_clone')
        @else
            @lang('base.license_create')
        @endif
        </h3>
            
    </div>                            
</div>

<div class="row form-wrapper">

    <div class="col-md-12 column">
    
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Asset Tag -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                 {{ Form::label_for($license, 'name', Lang::get('general.name'), array('class' => 'col-md-2 control-label')); }} 
                
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $license->name) }}" />
                        {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Serial NumberTag -->
            <div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'serial', Lang::get('general.serialnumber'), array('class' => 'col-md-2 control-label')); }} 
                
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="serial" id="serial" value="{{ Input::old('serial', $license->serial) }}" />
                        {{ $errors->first('serial', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>
 
            <!-- Manufacturer -->
            <div class="form-group {{ $errors->has('manufacturer_id') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'manufacturer_id', Lang::get('base.manufacturer'), array('class' => 'col-md-2 control-label')); }}                 
                <div class="col-md-7">
                    {{ Form::select('manufacturer_id', $manufacturer_list , Input::old('manufacturer_id', $license->manufacturer_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('manufacturer_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>
            
            <!-- Family -->
            <div class="form-group {{ $errors->has('family_id') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'family_id', Lang::get('base.family'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    {{ Form::select('family_id', $family_list , Input::old('family_id', $license->family_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('family_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>
            
            <!-- Location -->
            <div class="form-group {{ $errors->has('location_id') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'location_id', Lang::get('base.location'), array('class' => 'col-md-2 control-label')); }} 
               
                <div class="col-md-7">
                    {{ Form::select('location_id', $location_list , Input::old('location_id', $license->location_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('location_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    
        		<!-- Strict Assignment -->
                        &nbsp;&nbsp;<label>
			<input type="checkbox" value="1" name="strict_assignment" id="strict_assignment" {{ Input::old('strict_assignment', $license->strict_assignment) == '1'  || empty($asset->id) ? ' checked="checked"' : '' }}> @lang('general.strict_assignment')
			</label>
                </div>
                <div class="checkbox">

		</div>
            </div>
                        
            <!-- Supplier -->
            <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'supplier_id', Lang::get('base.supplier'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    {{ Form::select('supplier_id', $supplier_list , Input::old('supplier_id', $license->supplier_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('supplier_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>
            
            <!-- Service Agreement -->
            <div class="form-group {{ $errors->has('service_agreement_id') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'service_agreement_id', Lang::get('base.serviceagreement'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    {{ Form::select('service_agreement_id', $service_agreement_list , Input::old('service_agreement_id', $license->service_agreement_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('service_agreement_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>

            <!-- Licensed to Name -->
            <div class="form-group {{ $errors->has('license_name') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'license_name', Lang::get('admin/licenses/form.to_name'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                        <input class="form-control" type="text" name="license_name" id="license_name" value="{{ Input::old('license_name', $license->license_name) }}" />
                        {{ $errors->first('license_name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Licensed to Email -->
            <div class="form-group {{ $errors->has('license_email') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'license_email', Lang::get('admin/licenses/form.to_email'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                        <input class="form-control" type="text" name="license_email" id="license_email" value="{{ Input::old('license_email', $license->license_email) }}" />
                        {{ $errors->first('license_email', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- License Seats -->
            <div class="form-group {{ $errors->has('seats') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'seats', Lang::get('base.licenseseats_shortname'), array('class' => 'col-md-2 control-label')); }} 
                
                 </label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="seats" id="seats" value="{{ Input::old('seats', $license->seats) }}" />
                        {{ $errors->first('seats', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Order Number -->
            <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'order_number', Lang::get('general.ordernumber'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                        <input class="form-control" type="text" name="order_number" id="order_number" value="{{ Input::old('order_number', $license->order_number) }}" />
                        {{ $errors->first('order_number', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Purchase Date -->
            <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'purchase_date', Lang::get('general.purchasedate'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="input-group col-md-2">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $license->purchase_date) }}">
                    <span class="input-group-addon"><i class="icon-calendar"></i></span>
                {{ $errors->first('purchase_date', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                </div>
            </div>

            <!-- Purchase Cost -->
            <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'purchase_cost', Lang::get('general.purchasecost'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-addon">@lang('general.currency')</span>
                        <input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', number_format($license->purchase_cost,2)) }}" />
                        {{ $errors->first('purchase_cost', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                     </div>
                 </div>
            </div>

            <!-- Depreciation -->
            <div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'parent', Lang::get('base.depreciation'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                        {{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $license->depreciation_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                        {{ $errors->first('depreciation_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                {{ Form::label_for($license, 'notes', Lang::get('general.notes'), array('class' => 'col-md-2 control-label')); }} 
                
                <div class="col-md-7">
                    <textarea class="col-md-6 form-control" type="text" name="notes" id="notes">{{{ Input::old('notes', $license->notes) }}}</textarea>
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
