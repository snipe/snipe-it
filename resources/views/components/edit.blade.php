@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($component->id)
        {{ trans('admin/components/general.update') }}
    @else
        {{ trans('admin/components/general.create') }}
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
            @if ($component->id)
              {{ $component->name }}
            @endif
          </h3>
          <div class="box-tools pull-right">
            <button class="slideout-menu-toggle btn btn-box-tool btn-box-tool-lg" data-toggle="tooltip" title="Help"><i class="fa fa-question"></i></button>
          </div>
        </div><!-- /.box-header -->

       <div class="box-body">


         <!-- Name -->
         <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">

             {{ Form::label('name', trans('admin/components/table.title'), array('class' => 'col-md-3 control-label')) }}

             <div class="col-md-8 required">
                 <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $component->name) }}" />
                 {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
             </div>
         </div>

     	<!-- Category -->
         <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">

     		     {{ Form::label('category_id', trans('general.category'), array('class' => 'col-md-3 control-label')) }}

                 <div class="col-md-8 required">
                     {{ Form::select('category_id', $category_list , Input::old('category_id', $component->category_id), array('class'=>'select2', 'style'=>'width:100%')) }}
                     {!! $errors->first('category_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                 </div>
         </div>

           <!-- QTY -->
           <div class="form-group {{ $errors->has('total_qty') ? ' has-error' : '' }}">

               {{ Form::label('total_qty', trans('general.quantity'), array('class' => 'col-md-3 control-label')) }}

               <div class="col-md-2 required">
                   <input class="form-control" type="text" name="total_qty" id="total_qty" value="{{ Input::old('qty', $component->total_qty) }}" />

               </div>
               {!! $errors->first('total_qty', ' <div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}
           </div>

           <!-- Min QTY -->
           <div class="form-group{{ $errors->has('min_amt') ? ' has-error' : '' }}">

               {{ Form::label('min_amt', trans('general.min_amt'), array('class' => 'col-md-3 control-label')) }}

               <div class="col-md-2">
                   <input class="form-control" type="text" name="min_amt" id="min_amt" value="{{ Input::old('qty', $component->min_amt) }}" />
               </div>
               <div class="col-md-1 text-left">
                   <a href="#" data-toggle="tooltip" title="{{ trans('general.min_amt_help') }}"><i class="fa fa-info-circle"></i></a>
               </div>
               <div class="col-md-12">
                   {!! $errors->first('min_amt', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
               </div>


           </div>

           <!-- Serial -->
           <div class="form-group {{ $errors->has('serial_number') ? ' has-error' : '' }}">

               {{ Form::label('name', trans('admin/hardware/form.serial'), array('class' => 'col-md-3 control-label')) }}

               <div class="col-md-8">
                   <input class="form-control" type="text" name="serial_number" id="serial_number" value="{{ Input::old('serial_number', $component->serial_number) }}" />
                   {!! $errors->first('serial_number', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
               </div>
           </div>


           <!-- Company -->
           @if (\App\Models\Company::isCurrentUserAuthorized())
               <div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}">

                       {{ Form::label('company_id', trans('general.company'), array('class' => 'col-md-3 control-label')) }}

                   <div class="col-md-8">
                       {{ Form::select('company_id', $company_list , Input::old('company_id', $component->company_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                       {!! $errors->first('company_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                   </div>
               </div>
       @endif

         <!--  Location -->
         <div class="form-group {{ $errors->has('location_id') ? ' has-error' : '' }}">

            {{ Form::label('location_id', trans('general.location'), array('class' => 'col-md-3 control-label')) }}

                 <div class="col-md-7 col-sm-12">
                     {{ Form::select('location_id', $location_list , Input::old('location_id', $component->location_id), array('class'=>'select2', 'style'=>'width:350px')) }}

                     {!! $errors->first('location_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                 </div>
         </div>


         <!-- Order Number -->
         <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">

     		     {{ Form::label('order_number', trans('admin/components/general.order'), array('class' => 'col-md-3 control-label')) }}

             <div class="col-md-3">
                 <input class="form-control" type="text" name="order_number" id="order_number" value="{{ Input::old('order_number', $component->order_number) }}" />
                 {!! $errors->first('order_number', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
             </div>
         </div>

         <!-- Purchase Date -->
         <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">

     		     {{ Form::label('purchase_date', trans('admin/components/general.date'), array('class' => 'col-md-3 control-label')) }}

             <div class="input-group col-md-3">
                 <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="{{ trans('general.select_date') }}" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $component->purchase_date) }}">
                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                 {!! $errors->first('purchase_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
             </div>
         </div>

         <!-- Purchase Cost -->
         <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">

     		     {{ Form::label('purchase_cost', trans('admin/components/general.cost'), array('class' => 'col-md-3 control-label')) }}

             <div class="col-md-2">
                 <div class="input-group">
                     <span class="input-group-addon">
                         {{ \App\Models\Setting::first()->default_currency }}
                     </span>
                     <input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', \App\Helpers\Helper::formatCurrencyOutput($component->purchase_cost)) }}" />
                     {!! $errors->first('purchase_cost', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                 </div>
             </div>
         </div>



      </div>
      <div class="box-footer text-right">
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
      </div>
    </div>

  </div>
</div>


<div class="slideout-menu">
  <a href="#" class="slideout-menu-toggle pull-right">×</a>
	<h3>
    {{ trans('admin/components/general.about_components_title') }}
  </h3>
	<p>{{ trans('admin/components/general.about_components_text') }}</p>
</div>



@stop
