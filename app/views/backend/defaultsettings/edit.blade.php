@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($defaultsetting->id)
        @lang('base.defaultsetting_update') ::
    @else
        @lang('base.defaultsetting_create') ::
    @endif
@parent
@stop

{{-- Page content --}}
@section('content')

<form class="form-horizontal" method="post" action="" autocomplete="off">
    
<div class="row header">
    <div class="col-md-10">
            
        <button type="submit" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>            
        <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
            
        <h3>
        @if ($defaultsetting->id)
            @lang('base.defaultsetting_update')
        @else
            @lang('base.defaultsetting_create')
        @endif
        </h3>
            
    </div>                            
</div>

<div class="col-md-12 bio">

    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('general.setting')
                 </label>
                 </label>
                    <div class="col-md-7">                        
                        {{ Form::label_for($defaultsetting, 'name', Lang::get('admin/defaultsettings/form.values.' . $defaultsetting->name), array('class' => 'control-label')) }}
                        {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                 
            </div>
            <div class="form-group {{ $errors->has('value') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('general.value')</label>
                <div class="col-md-7">
                    {{ Form::select('value', $option_list, $defaultsetting->value, array('class'=>'select2', 'style'=>'min-width:350px')) }}
                </div>
            </div>

            <!-- Form actions -->
            <div class="form-group">
                <label class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <a href="{{ URL::previous() }}" class="btn btn-default"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>
                    </div>
            </div>

</div>

</form>
    
@stop
