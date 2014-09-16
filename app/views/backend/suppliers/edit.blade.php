@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($supplier->id)
        @lang('base.supplier_update') ::
    @else
        @lang('base.supplier_create') ::
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
        @if ($supplier->id)
            @lang('base.supplier_update')
        @elseif(isset($clone_supplier))
            @lang('base.supplier_clone')
        @else
            @lang('base.supplier_create')
        @endif
        </h3>
            
    </div>                            
</div>

<div class="col-md-12">

    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('general.name')
                <i class='icon-asterisk'></i></label>
                </label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $supplier->name) }}}" />
                        {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="address" class="col-md-2 control-label">@lang('general.address')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="address" id="address" value="{{{ Input::old('address', $supplier->address) }}}" />
                        {{ $errors->first('address', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
                <label for="address2" class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="address2" id="address2" value="{{{ Input::old('address2', $supplier->address2) }}}" />
                        {{ $errors->first('address2', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                <label for="city" class="col-md-2 control-label">@lang('general.city')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="city" id="city" value="{{{ Input::old('city', $supplier->city) }}}" />
                        {{ $errors->first('city', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>


            <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                <label for="state" class="col-md-2 control-label">@lang('general.state')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="state" id="state" value="{{{ Input::old('state', $supplier->state) }}}" />
                        {{ $errors->first('state', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>
            
            <!-- Country -->
            <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                <label for="country" class="col-md-2 control-label">@lang('general.country')
                </label>
                 </label>
                    <div class="col-md-7">

                         {{ Form::countries('country', Input::old('country', $supplier->country), 'select2') }}
                        
                        {{ $errors->first('country', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>
    
            <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
                <label for="zip" class="col-md-2 control-label">@lang('general.postalcode')</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" name="zip" id="zip" value="{{{ Input::old('zip', $supplier->zip) }}}" />
                        {{ $errors->first('zip', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>


            <div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
                <label for="contact" class="col-md-2 control-label">@lang('general.contact')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="contact" id="contact" value="{{{ Input::old('contact', $supplier->contact) }}}" />
                        {{ $errors->first('contact', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>


            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="phone" class="col-md-2 control-label">@lang('general.phone')</label>
                    <div class="col-md-4">
                        <input class="form-control" type="text" name="phone" id="phone" value="{{{ Input::old('phone', $supplier->phone) }}}" />
                        {{ $errors->first('phone', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('fax') ? ' has-error' : '' }}">
                <label for="fax" class="col-md-2 control-label">@lang('general.fax')</label>
                    <div class="col-md-4">
                        <input class="form-control" type="text" name="fax" id="fax" value="{{{ Input::old('fax', $supplier->fax) }}}" />
                        {{ $errors->first('fax', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-2 control-label">@lang('general.email')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="email" id="email" value="{{{ Input::old('email', $supplier->email) }}}" />
                        {{ $errors->first('email', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
                <label for="url" class="col-md-2 control-label">@lang('general.website')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="url" id="url" value="{{{ Input::old('url', $supplier->url) }}}" />
                        {{ $errors->first('url', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>


            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-2 control-label">@lang('general.notes')</label>
                    <div class="col-md-7">
                        <textarea class="form-control" type="text" name="notes" id="notes" >{{{ Input::old('notes', $supplier->notes) }}}</textarea>
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
</form>

@stop
