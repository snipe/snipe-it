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
                    </div>
                    <div class="form-group {{ $errors->has('asset_tag') ? 'has-error' : '' }}">
                        {{ Form::label('asset_tag', 'Asset Tag', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('asset_tag', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('manufacturer') ? 'has-error' : '' }}">
                        {{ Form::label('manufacturer', 'Manufacturer', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('manufacturer', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('model') ? 'has-error' : '' }}">
                        {{ Form::label('model', 'Model', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('model', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('serial') ? 'has-error' : '' }}">
                        {{ Form::label('serial', 'Serial', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('serial', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('purchase_date') ? 'has-error' : '' }}">
                        {{ Form::label('purchase_date', 'Purchase Date', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('purchase_date', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('purchase_cost') ? 'has-error' : '' }}">
                        {{ Form::label('purchase_cost', 'Purchase Cost', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('purchase_cost', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('order') ? 'has-error' : '' }}">
                        {{ Form::label('order', 'Order Number', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('order', '1') }}
                    </div>
                     <div class="form-group {{ $errors->has('supplier') ? 'has-error' : '' }}">
                        {{ Form::label('supplier', 'Supplier', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('supplier', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
                        {{ Form::label('location', 'Location', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('location', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('assigned_to') ? 'has-error' : '' }}">
                        {{ Form::label('assigned_to', 'Assigned To', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('assigned_to', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {{ Form::label('status', 'Status', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('status', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('warranty') ? 'has-error' : '' }}">
                        {{ Form::label('warranty', 'Warranty', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('warranty', '1') }}
                    </div>
                    <div class="form-group {{ $errors->has('depreciation') ? 'has-error' : '' }}">
                        {{ Form::label('depreciation', 'Depreciation', array('class' => 'col-md-2 control-label')) }}
                        {{ Form::checkbox('depreciation', '1') }}
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
    <p>
        @lang('admin/reports/general.info')
    </p>
</div>
@stop