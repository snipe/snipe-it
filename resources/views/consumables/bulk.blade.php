@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/consumables/form.update') }} 
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

    <p>{{ trans('admin/consumables/form.bulk_update_help') }}</p> 

    <div class="callout callout-warning">
      <i class="fa fa-warning"></i> {{ trans('admin/consumables/form.bulk_update_warn', ['consumable_count' => count($consumables)]) }} 
    </div>

    <form class="form-horizontal" method="post" action="{{ route('consumables/bulksave') }}" autocomplete="off" role="form">
      {{ csrf_field() }}

      <div class="box box-default">
        <div class="box-body">

            <!-- Company -->
            @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
            
            <!-- Category -->
            <div id="{{ 'category_id' }}" class="form-group category_id">

                {{ Form::label('category_id', trans('general.category'), array('class' => 'col-md-3 control-label')) }}

                <div class="col-md-7">
                    <select class="js-data-ajax" data-endpoint="categories/{{ (isset($category_type)) ? $category_type : 'consumable' }}" data-placeholder="{{ trans('general.select_category') }}" name="category_id" style="width: 100%" id="category_select_id" aria-label="category_id">
                        <option value=""  role="option">{{ trans('general.select_category') }}</option>

                    </select>
                </div>
                <div class="col-md-1 col-sm-1 text-left">
                    @can('create', \App\Models\Category::class)
                        @if ((!isset($hide_new)) || ($hide_new!='true'))
                            <a href='{{ route('modal.show',['type' => 'category', 'category_type' => isset($category_type) ? $category_type : 'consumable' ]) }}' data-toggle="modal"  data-target="#createModal" data-select='category_select_id' class="btn btn-sm btn-primary">New</a>
                        @endif
                    @endcan
                </div>


                {!! $errors->first('category_id', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
            </div>
            
            <!-- Manufacturer -->
            <div id="manufacturer_id" class="form-group manufacturer_id">
                {{ Form::label('manufacturer_id', trans('general.manufacturer'), array('class' => 'col-md-3 control-label')) }}

                <div class="col-md-7">
                    <select class="js-data-ajax" data-endpoint="manufacturers" data-placeholder="{{ trans('general.select_manufacturer') }}" name="manufacturer_id" style="width: 100%" id="manufacturer_select_id" aria-label="manufacturer_id">
                        <option value=""  role="option">{{ trans('general.select_manufacturer') }}</option>
                    </select>
                </div>

                <div class="col-md-1 col-sm-1 text-left">
                    @can('create', \App\Models\Manufacturer::class)
                        @if ((!isset($hide_new)) || ($hide_new!='true'))
                            <a href='{{ route('modal.show', 'manufacturer') }}' data-toggle="modal"  data-target="#createModal" data-select='manufacturer_select_id' class="btn btn-sm btn-primary">New</a>
                        @endif
                    @endcan
                </div>


                {!! $errors->first('manufacturer_id', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}
            </div>
            
            <!-- Location -->
            <div id="location_id" class="form-group location_id"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>

                {{ Form::label('location_id', trans('general.location'), array('class' => 'col-md-3 control-label')) }}
                <div class="col-md-6">
                    <select class="js-data-ajax" data-endpoint="locations" data-placeholder="{{ trans('general.select_location') }}" name="location_id" style="width: 100%" id="location_id_location_select" aria-label="location_id">
                        <option value=""  role="option">{{ trans('general.select_location') }}</option>
                    </select>
                </div>
            
                <div class="col-md-1 col-sm-1 text-left">
                    @can('create', \App\Models\Location::class)
                        @if ((!isset($hide_new)) || ($hide_new!='true'))
                        <a href='{{ route('modal.show', 'location') }}' data-toggle="modal"  data-target="#createModal" data-select='location_id_location_select' class="btn btn-sm btn-primary">New</a>
                        @endif
                    @endcan
                </div>
            
                {!! $errors->first('location_id', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}

                @if (isset($help_text))
                <div class="col-md-7 col-sm-11 col-md-offset-3">
                    <p class="help-block">{{ $help_text }}</p>
                </div>
                @endif
            </div>

            <!-- Model Number -->
            <div class="form-group {{ $errors->has('model_number') ? ' has-error' : '' }}">
                <label for="model_number" class="col-md-3 control-label">{{ trans('general.model_no') }}</label>
                <div class="col-md-7">
                <input class="form-control" type="text" name="model_number" aria-label="model_number" id="model_number" value="" />
                    {!! $errors->first('model_number', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                </div>
            </div>

            <!-- Order Number -->
            <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
               <label for="order_number" class="col-md-3 control-label">{{ trans('general.order_number') }}</label>
               <div class="col-md-7 col-sm-12">
                   <input class="form-control" type="text" name="order_number" aria-label="order_number" id="order_number" value="" />
                   {!! $errors->first('order_number', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
               </div>
            </div>
            
            <!-- Purchase Date -->
            <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
               <label for="purchase_date" class="col-md-3 control-label">{{ trans('general.purchase_date') }}</label>
               <div class="input-group col-md-3">
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                        <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="purchase_date" id="purchase_date" value="">
                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                   </div>
                   {!! $errors->first('purchase_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
               </div>
            </div>
            
            <!-- Purchase Cost -->
            <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
                <label for="purchase_cost" class="col-md-3 control-label">{{ trans('general.purchase_cost') }}</label>
                <div class="col-md-9">
                    <div class="input-group col-md-4" style="padding-left: 0px;">
                        <input class="form-control" type="text" name="purchase_cost" aria-label="purchase_cost" id="purchase_cost" value="" />
                        <span class="input-group-addon">
                            @if (isset($currency_type))
                                {{ $currency_type }}
                            @else
                                {{ $snipeSettings->default_currency }}
                            @endif
                        </span>
                    </div>
                    <div class="col-md-9" style="padding-left: 0px;">
                        {!! $errors->first('purchase_cost', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                    </div>
                </div>
            </div>
            
            <!-- QTY -->
            <div class="form-group {{ $errors->has('qty') ? ' has-error' : '' }}">
                <label for="qty" class="col-md-3 control-label">{{ trans('general.quantity') }}</label>
                <div class="col-md-7">
                   <div class="col-md-2" style="padding-left:0px">
                       <input class="form-control" type="text" name="qty" aria-label="qty" id="qty" value="">
                   </div>
                   {!! $errors->first('qty', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
               </div>
            </div>
            
            <!-- Min QTY -->
            <div class="form-group{{ $errors->has('min_amt') ? ' has-error' : '' }}">
                <label for="min_amt" class="col-md-3 control-label">{{ trans('general.min_amt') }}</label>
                <div class="col-md-9">
                   <div class="col-md-2" style="padding-left:0px">
                        <input class="form-control col-md-3" type="text" name="min_amt" id="min_amt" aria-label="min_amt" value="" />
                    </div>
                        <div class="col-md-7" style="margin-left: -15px;">
                            <a href="#" data-toggle="tooltip" title="{{ trans('general.min_amt_help') }}"><i class="fa fa-info-circle" aria-hidden="true"></i>
                            <span class="sr-only">{{ trans('general.min_amt_help') }}</span>
                        </a>

                    </div>
                    <div class="col-md-12">
                       {!! $errors->first('min_amt', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                    </div>
                </div>
            </div>

          @foreach ($consumables as $key => $value)
            <input type="hidden" name="ids[{{ $key }}]" value="1">
          @endforeach
        </div> <!--/.box-body-->

        <div class="text-right box-footer">
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
        </div>
      </div> <!--/.box.box-default-->
    </form>
  </div> <!--/.col-md-8-->
</div>
@stop
