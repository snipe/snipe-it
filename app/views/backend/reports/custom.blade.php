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


                    <div class="checkbox col-md-12">
                    	<label>
                     	{{ Form::checkbox('asset_name', '1') }}
                        @lang('admin/settings/general.display_asset_name')
                        </label>

                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                    	{{ Form::checkbox('asset_tag', '1') }}
                        @lang('general.asset_tag')
						</label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                    	 {{ Form::checkbox('manufacturer', '1') }}
                       	@lang('general.manufacturer')
						</label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                        {{ Form::checkbox('model', '1') }}
                        @lang('general.asset_models')
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                        {{ Form::checkbox('serial', '1') }}
                        @lang('admin/hardware/table.serial')
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>

                        {{ Form::checkbox('purchase_date', '1') }}
                          @lang('admin/licenses/table.purchase_date')
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                        {{ Form::checkbox('purchase_cost', '1') }}
                         @lang('admin/hardware/form.cost')
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                        {{ Form::checkbox('order', '1') }}
                        @lang('admin/hardware/form.order')
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                        {{ Form::checkbox('supplier', '1') }}
                        @lang('general.suppliers')
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                        {{ Form::checkbox('location', '1') }}
                        @lang('general.location')
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                        {{ Form::checkbox('assigned_to', '1') }}
                        @lang('admin/licenses/table.assigned_to')
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                        {{ Form::checkbox('status', '1') }}
                        @lang('general.status')
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                        {{ Form::checkbox('warranty', '1') }}
                        @lang('admin/hardware/form.warranty')
                        </label>
                    </div>
                    <div class="checkbox col-md-12">
                    	<label>
                        {{ Form::checkbox('depreciation', '1') }}
                        @lang('general.depreciation')
                        </label>
                    </div>

                    <!-- Form actions -->
                    <div class="form-group" style="padding-top: 30px">
                        <label class="col-md-2 control-label"></label>
                        <div class="controls">
                            <button type="submit" class="btn btn-success"><i class="fa fa-download icon-white"></i> @lang('general.generate')</button>
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
