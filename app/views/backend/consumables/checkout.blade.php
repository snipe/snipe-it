@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
     @lang('admin/hardware/general.checkout') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right">
        <i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
        <h3> @lang('general.checkout')</h3>
    </div>
</div>

<div class="row form-wrapper">
<!-- left column -->
<div class="col-md-10 column">

<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />


			@if ($consumable->name)
            <!-- consumable name -->
            <div class="form-group">
            <label class="col-sm-3 control-label">@lang('admin/consumables/general.consumable_name')</label>
                <div class="col-md-6">
                  <p class="form-control-static">{{{ $consumable->name }}}</p>
                </div>
            </div>
            @endif

    
            <!-- User -->

            <div class="form-group {{ $errors->has('assigned_to') ? ' has-error' : '' }}">
                <label for="assigned_to" class="col-md-3 control-label">@lang('admin/hardware/form.checkout_to')
                 <i class='icon-asterisk'></i></label>
                <div class="col-md-9">
                    {{ Form::select('assigned_to', $users_list , Input::old('assigned_to', $consumable->assigned_to), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('assigned_to', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

			@if ($consumable->category->require_acceptance=='1')
			<div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                  <p class="hint-block">@lang('admin/categories/general.required_acceptance')</p>
                </div>
            </div>
            @endif

            @if ($consumable->getEula())
            <div class="form-group">

                <div class="col-md-9 col-md-offset-3">
                  <p class="hint-block">@lang('admin/categories/general.required_eula')</p>
                </div>
            </div>
			@endif


            <!-- Form actions -->
            <div class="form-group">
            <label class="col-md-3 control-label"></label>
                <div class="col-md-7">
                    <a class="btn btn-link" href="{{ URL::previous() }}"> @lang('button.cancel')</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
                </div>
            </div>



</form>

</div>
</div>
@stop
