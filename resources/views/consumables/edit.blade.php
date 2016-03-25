@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($consumable->id)
        {{ trans('admin/consumables/general.update') }}
    @else
        {{ trans('admin/consumables/general.create') }}
    @endif
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-8 col-md-offset-2">



    <form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">
            @if ($consumable->id)
              {{ $consumable->name }}
            @endif
          </h3>
          <div class="box-tools pull-right">
            <button class="slideout-menu-toggle btn btn-box-tool btn-box-tool-lg" data-toggle="tooltip" title="Help"><i class="fa fa-question"></i></button>
          </div>
        </div><!-- /.box-header -->

       <div class="box-body">
         <!-- Company -->
         @if (\App\Models\Company::isCurrentUserAuthorized())
             <div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}">
                 <div class="col-md-3">
                     {{ Form::label('company_id', Lang::get('general.company')) }}
                 </div>
                 <div class="col-md-7">
                     {{ Form::select('company_id', $company_list , Input::old('company_id', $consumable->company_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                     {!! $errors->first('company_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                 </div>
             </div>
         @endif

         <!-- Name -->
         <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
             <div class="col-md-3">
             	{{ Form::label('name', Lang::get('admin/consumables/table.title')) }}

             </div>
             <div class="col-md-9">
                 <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $consumable->name) }}" />
                 {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
             </div>
         </div>

     	<!-- Category -->
         <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
     	     <div class="col-md-3">
     		     {{ Form::label('category_id', Lang::get('general.category')) }}

              </div>
                 <div class="col-md-7">
                     {{ Form::select('category_id', $category_list , Input::old('category_id', $consumable->category_id), array('class'=>'select2', 'style'=>'width:100%')) }}
                     {!! $errors->first('category_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                 </div>
         </div>

         <!--  Location -->
         <div class="form-group {{ $errors->has('location_id') ? ' has-error' : '' }}">
            <div class="col-md-3">
            {{ Form::label('location_id', Lang::get('general.location')) }}
            </div>
                 <div class="col-md-7 col-sm-12">
                     {{ Form::select('location_id', $location_list , Input::old('location_id', $consumable->location_id), array('class'=>'select2', 'style'=>'width:350px')) }}

                     {!! $errors->first('location_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                 </div>
         </div>


         <!-- Order Number -->
         <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
             <div class="col-md-3">
     		     {{ Form::label('order_number', Lang::get('admin/consumables/general.order')) }}
             </div>
             <div class="col-md-3">
                 <input class="form-control" type="text" name="order_number" id="order_number" value="{{ Input::old('order_number', $consumable->order_number) }}" />
                 {!! $errors->first('order_number', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
             </div>
         </div>

         <!-- Purchase Date -->
         <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
             <div class="col-md-3">
     		     {{ Form::label('purchase_date', Lang::get('admin/consumables/general.date')) }}
             </div>
             <div class="input-group col-md-3">
                 <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="{{ trans('general.select_date') }}" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $consumable->purchase_date) }}">
                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                 {!! $errors->first('purchase_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
             </div>
         </div>

         <!-- Purchase Cost -->
         <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
             <div class="col-md-3">
     		     {{ Form::label('purchase_cost', Lang::get('admin/consumables/general.cost')) }}
             </div>
             <div class="col-md-2">
                 <div class="input-group">
                     <span class="input-group-addon">
                         {{ \App\Models\Setting::first()->default_currency }}
                     </span>
                     <input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', number_format($consumable->purchase_cost,2)) }}" />
                     {!! $errors->first('purchase_cost', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                 </div>
             </div>
         </div>

         <!-- QTY -->
         <div class="form-group {{ $errors->has('qty') ? ' has-error' : '' }}">
             <div class="col-md-3">
             	{{ Form::label('qty', Lang::get('general.quantity')) }}
             </div>
             <div class="col-md-9" style="margin-left: -15px">
                 <div class="col-md-2">
                     <input class="form-control" type="text" name="qty" id="qty" value="{{ Input::old('qty', $consumable->qty) }}" />
                 </div>
                 {!! $errors->first('qty', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
             </div>
         </div>


         <!-- Min QTY -->
         <div class="form-group{{ $errors->has('min_amt') ? ' has-error' : '' }}">
             <div class="col-md-3">
             	{{ Form::label('min_amt', Lang::get('general.min_amt')) }}
             </div>
             <div class="col-md-9" style="margin-left: -15px">
                 <div class="col-md-2">
     	           <input class="form-control col-md-3" type="text" name="min_amt" id="min_amt" value="{{ Input::old('qty', $consumable->min_amt) }}" />
                </div>
                <div class="col-md-7" style="margin-left: -15px;">
                  <a href="#" data-toggle="tooltip" title="{{ trans('general.min_amt_help') }}"><i class="fa fa-info-circle"></i></a>
                </div>
                <div class="col-md-12">
                 {!! $errors->first('min_amt', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
               </div>
             </div>
           </div>



      </div>
      <div class="box-footer text-right">
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
      </div>
    </div>

  </div>



<div class="slideout-menu">
  <a href="#" class="slideout-menu-toggle pull-right">×</a>
	<h3>
    {{ trans('admin/consumables/general.about_consumables_title') }}
  </h3>
	<p>{{ trans('admin/consumables/general.about_consumables_text') }}</p>
</div>


@stop
