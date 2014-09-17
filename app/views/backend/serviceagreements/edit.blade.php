@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
        @lang('base.serviceagreement') ::
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
        @if ($serviceagreement->id)
            @lang('base.serviceagreement_update')
        @else
            @lang('base.serviceagreement_create')
        @endif
        </h3>
            
    </div>                            
</div>

<div class="row form-wrapper">
            <!-- left column -->
            <div class="col-md-12 column">

                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                
                                <!-- Name -->
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreement, 'name', Lang::get('general.name'), array('class' => 'col-md-2 control-label')) }}
                                        <div class="col-md-7">
                                            {{ Form::text_for($serviceagreement, 'name',array('class' => 'form-control'),$errors  ) }}
                                        </div>
                                    </div>
                                
                                <!-- Contract Number -->
                                    <div class="form-group {{ $errors->has('contract_number') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreement, 'contract_number', Lang::get('admin/serviceagreements/form.contract_number'), array('class' => 'col-md-2 control-label')); }} 

                                        <div class="col-md-7">
                                           {{ Form::text_for($serviceagreement, 'contract_number',array('class' => 'form-control'),$errors  ) }}
                                        </div>
                                    </div> 

                                <!-- Agreement Type -->
                                    <div class="form-group {{ $errors->has('service_agreement_type_id') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreement, 'service_agreement_type_id', Lang::get('general.type'), array('class' => 'col-md-2 control-label')); }} 

                                        <div class="col-md-7">
                                           {{ Form::select('service_agreement_type_id', $service_agreement_type_list , 
                                                Input::old('service_agreement_type_id', 
                                                $serviceagreement->service_agreement_type_id), 
                                                array('class'=>'select2', 'style'=>'min-width:350px')) }}
                                            {{ $errors->first('service_agreement_type_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}             
                                        </div>
                                    </div> 
                                
                                <!-- Management URL -->
                                    <div class="form-group {{ $errors->has('management_url') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreement, 'management_url', Lang::get('admin/serviceagreements/form.management_url'), array('class' => 'col-md-2 control-label')) }}
                                        <div class="col-md-7">
                                            {{ Form::text_for($serviceagreement, 'management_url',array('class' => 'form-control'),$errors  ) }}
                                        </div>
                                    </div>
                                
                                <!-- Registered to -->
                                    <div class="form-group {{ $errors->has('registered_to') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreement, 'registered_to', Lang::get('admin/serviceagreements/form.registered_to'), array('class' => 'col-md-2 control-label')); }} 

                                        <div class="col-md-7">
                                           {{ Form::text_for($serviceagreement, 'registered_to',array('class' => 'form-control'),$errors  ) }}
                                        </div>
                                    </div> 
                                
                                <!-- Term Months -->
                                    <div class="form-group {{ $errors->has('term_months') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreement, 'term_months', Lang::get('general.lengthmonths'), array('class' => 'col-md-2 control-label')); }} 

                                        <div class="col-md-2">
                                           {{ Form::text_for($serviceagreement, 'term_months',array('class' => 'form-control'),$errors  ) }}
                                        </div>
                                    </div>                                                               
                                
                                <!-- Location -->
                                    <div class="form-group {{ $errors->has('location_id') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreement, 'location_id', Lang::get('base.location'), array('class' => 'col-md-2 control-label')); }}
                                       
                                        <div class="col-md-7">
                                            {{ Form::select('location_id', $location_list , Input::old('location_id', $serviceagreement->location_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                                            {{ $errors->first('location_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}

                                                <!-- Strict Assignment -->
                                                &nbsp;&nbsp;<label>
                                                <input type="checkbox" value="1" name="strict_assignment" id="strict_assignment" {{ Input::old('strict_assignment', $serviceagreement->strict_assignment) == '1' ? ' checked="checked"' : '' }}> @lang('general.strict_assignment')
                                                </label>
                                        </div>
                                        <div class="checkbox">

                                        </div>
                                    </div>
                                
                                <!-- Maker/Manufacturer -->
                                                                
                                <!-- Supplier -->
                                    <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreement, 'supplier_id', Lang::get('base.supplier'), array('class' => 'col-md-2 control-label')); }} 
                                        <div class="col-md-7">
                                           {{ Form::select('supplier_id', $supplier_list , Input::old('supplier_id', $serviceagreement->supplier_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                                            {{ $errors->first('supplier_id', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}             
                                        </div>
                                    </div>
                              
                                <!-- Purchase Date -->
                                    <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
                                        <label for="purchase_date" class="col-md-2 control-label">@lang('general.purchasedate')</label>
                                        <div class="input-group col-md-2">
                                            <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $serviceagreement->purchase_date) }}">
                                            <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                        {{ $errors->first('purchase_date', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                        </div>
                                    </div>
                                
                                <!-- Purchase Cost -->
                                    <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreement, 'purchase_cost', Lang::get('general.purchasecost'), array('class' => 'col-md-2 control-label')); }} 

                                        <div class="col-md-2">
                                               {{ Form::text_for($serviceagreement, 'purchase_cost',array('class' => 'form-control'),$errors  ) }}
                                        </div>
                                    </div>                                

                                <!-- Notes -->
                                <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                                    <label for="notes" class="col-md-2 control-label">@lang('general.notes')</label>
                                    <div class="col-md-7">
                                        <textarea class="col-md-6 form-control" type="text" name="notes" id="notes">{{{ Input::old('notes', $serviceagreement->notes) }}}</textarea>
                                        {{ $errors->first('notes', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                    </div>
                                </div>
            
            <!-- Form actions -->
                <div class="form-group">
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
