@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($license->id)
        @lang('admin/licenses/form.update') ::
    @else
        @lang('admin/licenses/form.create') ::
    @endif
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
            <a href="{{ URL::previous() }}" class="btn-flat gray pull-right right">
            <i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
        <h3>
        @if ($license->id)
            @lang('admin/licenses/form.update')
        @else
            @lang('admin/licenses/form.create')
        @endif
        </h3>
    </div>
</div>

<div class="row form-wrapper">

<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            @if (Company::isCurrentUserAuthorized())
                <!-- Company -->
                <div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}">
                    <div class="col-md-3 control-label">
                        {{ Form::label('company_id', Lang::get('general.company')) }}
                    </div>
                    <div class="col-md-7">
                        {{ Form::select('company_id', $company_list , Input::old('company_id', $license->company_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                        {{ $errors->first('company_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
                </div>
            @endif

            <!-- License -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">@lang('admin/licenses/form.name')
                 <i class='fa fa-asterisk'></i></label>
                 </label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $license->name) }}}" />
                        {{ $errors->first('name', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Serial -->
            <div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
                <label for="serial" class="col-md-3 control-label">@lang('admin/licenses/form.serial')
                 <i class='fa fa-asterisk'></i></label>
                 </label>
                    <div class="col-md-7">
                        <textarea class="form-control" type="text" name="serial" id="serial">{{{ Input::old('serial', $license->serial) }}}</textarea>
                        {{ $errors->first('serial', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Licensed to name -->
            <div class="form-group {{ $errors->has('license_name') ? ' has-error' : '' }}">
                <label for="license_name" class="col-md-3 control-label">@lang('admin/licenses/form.to_name')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="license_name" id="license_name" value="{{{ Input::old('license_name', $license->license_name) }}}" />
                        {{ $errors->first('license_name', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Licensed to email -->
            <div class="form-group {{ $errors->has('license_email') ? ' has-error' : '' }}">
                <label for="license_email" class="col-md-3 control-label">@lang('admin/licenses/form.to_email')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="license_email" id="license_email" value="{{{ Input::old('license_email', $license->license_email) }}}" />
                        {{ $errors->first('license_email', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Seats -->
            <div class="form-group {{ $errors->has('seats') ? ' has-error' : '' }}">
                <label for="seats" class="col-md-3 control-label">@lang('admin/licenses/form.seats')
                 <i class='fa fa-asterisk'></i></label>
                 </label>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="seats" id="seats" value="{{{ Input::old('seats', $license->seats) }}}" />
                        {{ $errors->first('seats', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Reassignable -->
            <div class="form-group {{ $errors->has('reassignable') ? ' has-error' : '' }}">
                <label for="reassignable" class="col-md-3 control-label">@lang('admin/licenses/form.reassignable')</label>
                <div class="checkbox col-md-7 input-group" style="padding-left: 35px;">
                    {{ Form::Checkbox('reassignable', '1', Input::old('reassignable', $license->id ? $license->reassignable : '1')) }}
                    @lang('general.yes')
                </div>
            </div>




            <!-- Supplier -->
            <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                <label for="supplier_id" class="col-md-3 control-label">@lang('admin/licenses/form.supplier')</label>
                <div class="col-md-7">
                    {{ Form::select('supplier_id', $supplier_list , Input::old('supplier_id', $license->supplier_id), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('supplier_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Order Number -->
            <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
                <label for="order_number" class="col-md-3 control-label">@lang('admin/licenses/form.order')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="order_number" id="order_number" value="{{{ Input::old('order_number', $license->order_number) }}}" />
                        {{ $errors->first('order_number', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Purchase Date -->
            <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
                <label for="purchase_date" class="col-md-3 control-label">@lang('admin/licenses/form.date')</label>
                <div class="input-group col-md-2">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="purchase_date" id="purchase_date" value="{{{ Input::old('purchase_date', $license->purchase_date) }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ $errors->first('purchase_date', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Purchase Cost -->
            <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
                <label for="purchase_cost" class="col-md-3 control-label">@lang('admin/licenses/form.cost')</label>
                <div class="col-md-2">
                    <div class="input-group">
                        <span class="input-group-addon">{{{ Setting::first()->default_currency }}}</span>
                        <input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', number_format($license->purchase_cost,2)) }}" />
                        {{ $errors->first('purchase_cost', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                     </div>
                 </div>
            </div>

            <!-- Purchase Order -->
            <div class="form-group {{ $errors->has('purchase_order') ? ' has-error' : '' }}">
                <label for="purchase_order" class="col-md-3 control-label">@lang('admin/licenses/form.purchase_order')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="purchase_order" id="purchase_order" value="{{{ Input::old('purchase_order', $license->purchase_order) }}}" />
                        {{ $errors->first('purchase_order', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>


            <!-- Expiration Date -->
            <div class="form-group {{ $errors->has('expiration_date') ? ' has-error' : '' }}">
                <label for="expiration_date" class="col-md-3 control-label">@lang('admin/licenses/form.expiration')</label>
                <div class="input-group col-md-2">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="expiration_date" id="expiration_date" value="{{{ Input::old('expiration_date', $license->expiration_date) }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ $errors->first('expiration_date', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Depreciation -->
            <div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
                <label for="parent" class="col-md-3 control-label">@lang('admin/licenses/form.depreciation')</label>
                    <div class="col-md-7">
                        {{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $license->depreciation_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                        {{ $errors->first('depreciation_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Maintained -->
            <div class="form-group {{ $errors->has('maintained') ? ' has-error' : '' }}">
                <label for="maintained" class="col-md-3 control-label">@lang('admin/licenses/form.maintained')</label>


                <div class="checkbox col-md-7 input-group" style="padding-left: 35px;">
					{{ Form::Checkbox('maintained', '1', Input::old('maintained', $license->maintained)) }}
					@lang('general.yes')




                </div>
            </div>

            <!-- Purchase Date -->
            <div class="form-group {{ $errors->has('termination_date') ? ' has-error' : '' }}">
                <label for="termination_date" class="col-md-3 control-label">@lang('admin/licenses/form.termination_date')</label>
                <div class="input-group col-md-2">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="termination_date" id="termination_date" value="{{{ Input::old('termination_date', $license->termination_date) }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    {{ $errors->first('termination_date', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-3 control-label">@lang('admin/licenses/form.notes')</label>
                <div class="col-md-7">
                    <textarea class="col-md-6 form-control" id="notes" name="notes">{{{ Input::old('notes', $license->notes) }}}</textarea>
                    {{ $errors->first('notes', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Form actions -->
                <div class="form-group">
                <label class="col-md-3 control-label"></label>
                    <div class="col-md-7">

                        <a class="btn btn-link" href="{{ URL::previous() }}">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
                    </div>
                </div>

</form>
</div>

@stop
