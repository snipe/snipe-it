@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($accessory->id)
        @lang('admin/accessories/general.update') ::
    @else
        @lang('admin/accessories/general.create') ::
    @endif
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
        <h3>
        @if ($accessory->id)
            @lang('admin/accessories/general.update')
        @else
            @lang('admin/accessories/general.create')
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

    <!-- Name -->
    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
        <div class="col-md-3">
        	{{ Form::label('name', Lang::get('admin/accessories/general.accessory_name')) }}
        	<i class='fa fa-asterisk'></i>
        </div>                        
        <div class="col-md-9">
            <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $accessory->name) }}}" />
            {{ $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
        </div>
    </div>
            						
	<!-- Category -->
    <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
	     <div class="col-md-3">
		     {{ Form::label('category_id', Lang::get('admin/accessories/general.accessory_category')) }}
			 <i class='fa fa-asterisk'></i>
         </div>   
            <div class="col-md-7">
                {{ Form::select('category_id', $category_list , Input::old('category_id', $accessory->category_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                {{ $errors->first('category_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
            </div>
    </div>
            
    <!-- QTY -->
    <div class="form-group {{ $errors->has('qty') ? ' has-error' : '' }}">
        <div class="col-md-3">
        	{{ Form::label('qty', Lang::get('admin/accessories/general.qty')) }}
        	<i class='fa fa-asterisk'></i>
        </div>                        
        <div class="col-md-9">
	        <div class="col-md-2">
            <input class="form-control" type="text" name="qty" id="qty" value="{{{ Input::old('qty', $accessory->qty) }}}" />
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
        
        <h6>@lang('admin/accessories/general.about_accessories_title')</h6>
        <p>@lang('admin/accessories/general.about_accessories_text') </p>

    </div>
</div>
</div>



@stop
