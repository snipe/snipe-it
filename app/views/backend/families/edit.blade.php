@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

    @if ($family->id)
        @lang('base.family_update') ::
    @else
        @lang('base.family_create') ::
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
        @if ($family->id)
            @lang('base.family_update')
        @elseif(isset($clone_family))
            @lang('base.family_clone')
        @else
            @lang('base.family_create')
        @endif
        </h3>
            
    </div>                            
</div>

<div class="row form-wrapper">

<div class="col-md-12">
    
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Common-Short Name -->
            <div class="form-group {{ $errors->has('common_name') ? ' has-error' : '' }}">
                <label for="common_name" class="col-md-2 control-label">@lang('general.common_name')
                 <i class='icon-asterisk'></i></label>
                 </label>
                    <div class="col-md-7">
                        <input size="40" maxlength="128" class="form-control" type="text" name="common_name" id="common_name" value="{{{ Input::old('common_name', $family->common_name) }}}" />
                    {{ $errors->first('common_name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('general.name')
                 <i class='icon-asterisk'></i></label></label>
                    <div class="col-md-7">
                        <input size="40" maxlength="128" class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $family->name) }}}" />
                    {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-2 control-label">@lang('general.notes')</label>
                    <div class="col-md-7">
                        <textarea class="form-control" type="text" name="notes" id="notes">{{{ Input::old('notes', $family->notes) }}}</textarea>
                    {{ $errors->first('notes', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
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
</div>
    
</form>

@stop
