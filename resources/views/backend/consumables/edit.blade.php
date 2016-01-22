@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($consumable->id)
        @lang('admin/consumables/general.update') ::
    @else
        @lang('admin/consumables/general.create') ::
    @endif
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
        <h3>
        @if ($consumable->id)
            @lang('admin/consumables/general.update')
        @else
            @lang('admin/consumables/general.create')
        @endif
</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

    <form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <!-- Company -->
    @if (Company::isCurrentUserAuthorized())
        <div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}">
            <div class="col-md-3">
                {{ Form::label('company_id', Lang::get('general.company')) }}
            </div>
            <div class="col-md-7">
                {{ Form::select('company_id', $company_list , Input::old('company_id', $consumable->company_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                {{ $errors->first('company_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
            </div>
        </div>
    @endif

    <!-- Name -->
    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
        <div class="col-md-3">
        	{{ Form::label('name', Lang::get('admin/consumables/table.title')) }}
        	<i class='fa fa-asterisk'></i>
        </div>
        <div class="col-md-9">
            <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $consumable->name) }}}" />
            {{ $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
        </div>
    </div>

	<!-- Category -->
    <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
	     <div class="col-md-3">
		     {{ Form::label('category_id', Lang::get('general.category')) }}
			 <i class='fa fa-asterisk'></i>
         </div>
            <div class="col-md-7">
                {{ Form::select('category_id', $category_list , Input::old('category_id', $consumable->category_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                {{ $errors->first('category_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
            </div>
    </div>

    <!--  Location -->
    <div class="form-group {{ $errors->has('location_id') ? ' has-error' : '' }}">
       <div class="col-md-3">
       {{ Form::label('location_id', Lang::get('general.location')) }}
       </div>
            <div class="col-md-7 col-sm-12">
                {{ Form::select('location_id', $location_list , Input::old('location_id', $consumable->location_id), array('class'=>'select2', 'style'=>'width:350px')) }}

                {{ $errors->first('location_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
            </div>
    </div>


    <!-- Order Number -->
    <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
        <div class="col-md-3">
		     {{ Form::label('order_number', Lang::get('admin/consumables/general.order')) }}
        </div>
        <div class="col-md-3">
            <input class="form-control" type="text" name="order_number" id="order_number" value="{{{ Input::old('order_number', $consumable->order_number) }}}" />
            {{ $errors->first('order_number', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
        </div>
    </div>

    <!-- Purchase Date -->
    <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
        <div class="col-md-3">
		     {{ Form::label('purchase_date', Lang::get('admin/consumables/general.date')) }}
        </div>
        <div class="input-group col-md-3">
            <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="@lang('general.select_date')" name="purchase_date" id="purchase_date" value="{{{ Input::old('purchase_date', $consumable->purchase_date) }}}">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            {{ $errors->first('purchase_date', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
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
                    {{{ Setting::first()->default_currency }}}
                </span>
                <input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', number_format($consumable->purchase_cost,2)) }}" />
                {{ $errors->first('purchase_cost', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
            </div>
        </div>
    </div>

    <!-- QTY -->
    <div class="form-group {{ $errors->has('qty') ? ' has-error' : '' }}">
        <div class="col-md-3">
        	{{ Form::label('qty', Lang::get('general.quantity')) }}
        	<i class='fa fa-asterisk'></i>
        </div>
        <div class="col-md-9">
            <div class="col-md-2">
                <input class="form-control" type="text" name="qty" id="qty" value="{{{ Input::old('qty', $consumable->qty) }}}" />
            </div>
            {{ $errors->first('qty', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
        </div>
    </div>



	<hr>
    <!-- Form actions -->
    <div class="form-group">

        <div class="col-md-7 col-md-offset-3">
            <a class="btn btn-link" href="{{ URL::previous() }}">@lang('button.cancel')</a>
            <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
        </div>
    </div>
</form>
<br><br><br>
</div>

    <!-- side address column -->
    <div class="col-md-3 col-xs-12 address pull-right">

        <h6>@lang('admin/consumables/general.about_consumables_title')</h6>
        <p>@lang('admin/consumables/general.about_consumables_text') </p>

    </div>
</div>
</div>



@stop
