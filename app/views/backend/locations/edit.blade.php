@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($location->id)
        @lang('base.location_update') ::
    @else
        @lang('base.location_create') ::
    @endif
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-10">
            
        <button type="submit" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>            
        <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
            
        <h3>
        @if ($location->id)
            @lang('base.location_update')
        @elseif(isset($clone_location))
            @lang('base.location_clone')
        @else
            @lang('base.location_create')
        @endif
        </h3>
            
    </div>                            
</div>

<div class="col-md-12">

<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Location Name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('general.name')
                 <i class='icon-asterisk'></i></label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $location->name) }}}" />
                    {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>
            
            <!-- Entity -->
            <div class="form-group {{ $errors->has('entity_id') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="entity_id">@lang('base.entity')</label>
                <div class="col-md-7">
                    {{ Form::select('entity_id', $entity_list , Input::old('entity_id', $location->entity_id), array('class'=>'select2', 'style'=>'width:250px')) }}
                    {{ $errors->first('entity_id', '<span class="alert-msg">:message</span>') }}
                </div>
            </div>
            
            <!-- Address -->
            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="address" class="col-md-2 control-label">@lang('general.address')
                 <i class='icon-asterisk'></i></label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="address" id="address" value="{{{ Input::old('address', $location->address) }}}" />
                    {{ $errors->first('address', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Address -->
            <div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
                <label for="address2" class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="address2" id="address2" value="{{{ Input::old('address2', $location->address2) }}}" />
                    {{ $errors->first('address2', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- City -->
            <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                <label for="city" class="col-md-2 control-label">@lang('general.city')
                 <i class='icon-asterisk'></i></label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="city" id="city" value="{{{ Input::old('city', $location->city) }}}" />
                    {{ $errors->first('city', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- City -->
            <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                <label for="state" class="col-md-2 control-label">@lang('general.state')
                 <i class='icon-asterisk'></i></label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="state" id="state" value="{{{ Input::old('state', $location->state) }}}" />
                    {{ $errors->first('state', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Zip -->
            <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
                <label for="zip" class="col-md-2 control-label">@lang('general.postalcode')</label>
                    <div class="col-md-3">
                        <input class="form-control" type="text" name="zip" id="zip" value="{{{ Input::old('zip', $location->zip) }}}" />
                    {{ $errors->first('zip', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Country -->
            <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                <label for="country" class="col-md-2 control-label">@lang('general.country')
                 <i class='icon-asterisk'></i></label>
                    <div class="col-md-7">
                         {{ Form::countries('country', Input::old('country', $location->country), 'select2') }}
                        {{ $errors->first('country', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-2 control-label">@lang('general.notes')</label>
                    <div class="col-md-7">
                        <textarea class="form-control" type="text" name="notes" id="notes">{{{ Input::old('notes', $location->notes) }}}</textarea>
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

</form>

</div>

@stop
