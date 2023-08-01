@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/hardware/form.update') }}
@parent
@stop


@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <p>{{ trans('admin/hardware/form.bulk_update_help') }}</p>

    <div class="callout callout-warning">
      <i class="fas fa-exclamation-triangle"></i> {{ trans_choice('admin/hardware/form.bulk_update_warn', count($assets), ['asset_count' => count($assets)]) }}
    </div>

    <form class="form-horizontal" method="post" action="{{ route('hardware/bulksave') }}" autocomplete="off" role="form">
      {{ csrf_field() }}

      <div class="box box-default">
        <div class="box-body">
          <!-- Purchase Date -->
          <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
            <label for="purchase_date" class="col-md-3 control-label">{{ trans('admin/hardware/form.date') }}</label>
            <div class="col-md-4">
              <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="purchase_date" id="purchase_date" value="{{ old('purchase_date') }}">
                <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
              </div>
              {!! $errors->first('purchase_date', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
            </div>
            <div class="col-md-5">
              <label class="form-control">
                {{ Form::checkbox('null_purchase_date', '1', false) }}
                {{ trans_choice('general.set_to_null', count($assets),['asset_count' => count($assets)]) }}
              </label>
            </div>

          </div>
          <!-- Expected Checkin Date -->
          <div class="form-group {{ $errors->has('expected_checkin') ? ' has-error' : '' }}">
             <label for="expected_checkin" class="col-md-3 control-label">{{ trans('admin/hardware/form.expected_checkin') }}</label>
             <div class="col-md-4">
                  <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                      <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="expected_checkin" id="expected_checkin" value="{{ old('expected_checkin') }}">
                      <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                 </div>

                 {!! $errors->first('expected_checkin', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
             </div>
              <div class="col-md-5">
                <label class="form-control">
                  {{ Form::checkbox('null_expected_checkin_date', '1', false, ['checked' => 'false']) }}
                  {{ trans_choice('general.set_to_null', count($assets), ['asset_count' => count($assets)]) }}
                </label>
              </div>
          </div>


          <!-- Status -->
          <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
            <label for="status_id" class="col-md-3 control-label">
              {{ trans('admin/hardware/form.status') }}
            </label>
            <div class="col-md-7">
              {{ Form::select('status_id', $statuslabel_list , old('status_id'), array('class'=>'select2', 'style'=>'width:100%', 'aria-label'=>'status_id')) }}
              {!! $errors->first('status_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

        @include ('partials.forms.edit.model-select', ['translated_name' => trans('admin/hardware/form.model'), 'fieldname' => 'model_id'])

          <!-- Default Location -->
        @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.default_location'), 'fieldname' => 'rtd_location_id'])

        <!-- Update actual location  -->
          <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
                <label class="form-control">
                  {{ Form::radio('update_real_loc', '1', old('update_real_loc'), ['checked'=> 'checked', 'aria-label'=>'update_real_loc']) }}
                  {{ trans('admin/hardware/form.asset_location_update_default_current') }}
                </label>
                <label class="form-control">
                  {{ Form::radio('update_real_loc', '0', old('update_real_loc'), ['aria-label'=>'update_default_loc']) }}
                  {{ trans('admin/hardware/form.asset_location_update_default') }}
                </label>

            </div>
          </div> <!--/form-group-->



          <!-- Purchase Cost -->
          <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
            <label for="purchase_cost" class="col-md-3 control-label">
              {{ trans('admin/hardware/form.cost') }}
            </label>
            <div class="input-group col-md-3">
              <span class="input-group-addon">{{ $snipeSettings->default_currency }}</span>
                <input type="text" class="form-control"  maxlength="10" placeholder="{{ trans('admin/hardware/form.cost') }}" name="purchase_cost" id="purchase_cost" value="{{ old('purchase_cost') }}">
                {!! $errors->first('purchase_cost', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <!-- Supplier -->
           @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])
          <!-- Company -->
          @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])

          <!-- Order Number -->
          <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
            <label for="order_number" class="col-md-3 control-label">
              {{ trans('admin/hardware/form.order') }}
            </label>
            <div class="col-md-7">
              <input class="form-control" type="text" maxlength="200" name="order_number" id="order_number" value="{{ old('order_number') }}" />
              {!! $errors->first('order_number', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <!-- Warranty -->
          <div class="form-group {{ $errors->has('warranty_months') ? ' has-error' : '' }}">
            <label for="warranty_months" class="col-md-3 control-label">
              {{ trans('admin/hardware/form.warranty') }}
            </label>
            <div class="col-md-3">
              <div class="input-group">
                <input class="col-md-3 form-control" maxlength="4" type="text" name="warranty_months" id="warranty_months" value="{{ old('warranty_months') }}" />
                <span class="input-group-addon">{{ trans('admin/hardware/form.months') }}</span>
                {!! $errors->first('warranty_months', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>
          </div>

          <!-- Next audit Date -->
          <div class="form-group {{ $errors->has('next_audit_date') ? ' has-error' : '' }}">
            <label for="next_audit_date" class="col-md-3 control-label">{{ trans('general.next_audit_date') }}</label>
            <div class="col-md-4">
              <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="next_audit_date" id="next_audit_date" value="{{ old('next_audit_date') }}">
                <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
              </div>

              {!! $errors->first('next_audit_date', '<span class="alert-msg" aria-hidden="true">
                <i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
            <div class="col-md-5">
              <label class="form-control">
                {{ Form::checkbox('null_next_audit_date', '1', false) }}
                {{ trans_choice('general.set_to_null', count($assets), ['asset_count' => count($assets)]) }}
              </label>
            </div>
          </div>

          <!-- Requestable -->
          <div class="form-group {{ $errors->has('requestable') ? ' has-error' : '' }}">
            <div class="control-label col-md-3">
              <strong>{{ trans('admin/hardware/form.requestable') }}</strong>
            </div>
            <div class="col-md-7">
              <label class="form-control">
                <input type="radio" name="requestable" value="1">
                {{ trans('general.yes')}}
              </label>
              <label class="form-control">
                <input type="radio" name="requestable" value="0">
                {{ trans('general.no')}}
              </label>
              <label class="form-control">
                <input type="radio" name="requestable" value="" checked>
                {{ trans('general.do_not_change')}}
              </label>
            </div>
          </div>

          @foreach ($assets as $key => $value)
            <input type="hidden" name="ids[{{ $value }}]" value="1">
          @endforeach
        </div> <!--/.box-body-->

        <div class="text-right box-footer">
          <button type="submit" class="btn btn-success"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
        </div>
      </div> <!--/.box.box-default-->
    </form>
  </div> <!--/.col-md-8-->
</div>
@stop
