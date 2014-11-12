@extends('backend/layouts/default')

{{-- Page Title --}}
@section('title')
@lang('general.custom_report') ::
@parent
@stop

{{-- Page Content --}}
@section('content')

<div id="pad-wrapper" class="user-profile">
    <h3 class="name">@lang('general.custom_report')</h3>
    <div class="row-fluid profile">
        <div class="col-md-9 bio">
            <div class="profile-box">
                {{ Form::open(['method' => 'post', 'class' => 'form-horizontal']) }}

                    <div class="form-group {{ $errors->has('asset_name') ? 'has-error' : '' }}">
                        {{ Form::label('asset_name', 'Asset Name', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('asset_name', '1') }}
                        {{ $errors->first('asset_name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('asset_tag') ? 'has-error' : '' }}">
                        {{ Form::label('asset_tag', 'Asset Tag', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('asset_tag', '1') }}
                        {{ $errors->first('asset_tag', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('manufacturer') ? 'has-error' : '' }}">
                        {{ Form::label('manufacturer', 'Manufacturer', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('manufacturer', '1') }}
                        {{ $errors->first('manufacturer', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('model') ? 'has-error' : '' }}">
                        {{ Form::label('model', 'Model', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('model', '1') }}
                        {{ $errors->first('model', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('serial') ? 'has-error' : '' }}">
                        {{ Form::label('serial', 'Serial', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('serial', '1') }}
                        {{ $errors->first('serial', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('purchase_date') ? 'has-error' : '' }}">
                        {{ Form::label('purchase_date', 'Purchase Date', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('purchase_date', '1') }}
                        {{ $errors->first('purchase_date', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('purchase_cost') ? 'has-error' : '' }}">
                        {{ Form::label('purchase_cost', 'Purchase Cost', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('purchase_cost', '1') }}
                        {{ $errors->first('purchase_cost', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('order') ? 'has-error' : '' }}">
                        {{ Form::label('order', 'Order Number', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('order', '1') }}
                        {{ $errors->first('order', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                     <div class="form-group {{ $errors->has('supplier') ? 'has-error' : '' }}">
                        {{ Form::label('supplier', 'Supplier', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('supplier', '1') }}
                        {{ $errors->first('supplier', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
                        {{ Form::label('location', 'Location', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('location', '1') }}
                        {{ $errors->first('location', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('assigned_to') ? 'has-error' : '' }}">
                        {{ Form::label('assigned_to', 'Assigned To', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('assigned_to', '1') }}
                        {{ $errors->first('assigned_to', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {{ Form::label('status', 'Status', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('status', '1') }}
                        {{ $errors->first('status', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('warranty') ? 'has-error' : '' }}">
                        {{ Form::label('warranty', 'Warranty', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('warranty', '1') }}
                        {{ $errors->first('warranty', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                    <div class="form-group {{ $errors->has('depreciation') ? 'has-error' : '' }}">
                        {{ Form::label('depreciation', 'Depreciation', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('depreciation', '1') }}
                        {{ $errors->first('depreciation', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>

                    <!-- Form actions -->
                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <div class="controls">
                            <button type="submit" class="btn-flat success"><i class="icon-download-alt icon-white"></i> Generate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3 address pull-right">
    <br /><br />
    <p>Select the options you want for your asset report</p>
</div>
@stop