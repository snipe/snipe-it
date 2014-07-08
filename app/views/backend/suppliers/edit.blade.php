@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($supplier->id)
        @lang('admin/suppliers/table.update') ::
    @else
        @lang('admin/suppliers/table.create') ::
    @endif
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="icon-circle-arrow-left icon-white"></i>  @lang('general.back')</a>
        <h3>
        @if ($supplier->id)
            @lang('admin/suppliers/table.update')
        @else
            @lang('admin/suppliers/table.create')
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
                <label for="name" class="col-md-3 control-label">@lang('admin/suppliers/table.name')
                <i class='icon-asterisk'></i></label>
                </label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $supplier->name) }}}" />
                        {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="address" class="col-md-3 control-label">@lang('admin/suppliers/table.address')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="address" id="address" value="{{{ Input::old('address', $supplier->address) }}}" />
                        {{ $errors->first('address', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
                <label for="address2" class="col-md-3 control-label"></label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="address2" id="address2" value="{{{ Input::old('address2', $supplier->address2) }}}" />
                        {{ $errors->first('address2', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                <label for="city" class="col-md-3 control-label">@lang('admin/suppliers/table.city')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="city" id="city" value="{{{ Input::old('city', $supplier->city) }}}" />
                        {{ $errors->first('city', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>


            <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                <label for="state" class="col-md-3 control-label">@lang('admin/suppliers/table.state')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="state" id="state" value="{{{ Input::old('state', $supplier->state) }}}" />
                        {{ $errors->first('state', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                <label for="country" class="col-md-3 control-label">@lang('admin/suppliers/table.country')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="country" id="country" value="{{{ Input::old('country', $supplier->country) }}}" />
                        {{ $errors->first('country', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
                <label for="zip" class="col-md-3 control-label">@lang('admin/suppliers/table.zip')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="zip" id="zip" value="{{{ Input::old('zip', $supplier->zip) }}}" />
                        {{ $errors->first('zip', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>


            <div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
                <label for="contact" class="col-md-3 control-label">@lang('admin/suppliers/table.contact')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="contact" id="contact" value="{{{ Input::old('contact', $supplier->contact) }}}" />
                        {{ $errors->first('contact', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>


            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="phone" class="col-md-3 control-label">@lang('admin/suppliers/table.phone')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="phone" id="phone" value="{{{ Input::old('phone', $supplier->phone) }}}" />
                        {{ $errors->first('phone', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('fax') ? ' has-error' : '' }}">
                <label for="fax" class="col-md-3 control-label">@lang('admin/suppliers/table.fax')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="fax" id="fax" value="{{{ Input::old('fax', $supplier->fax) }}}" />
                        {{ $errors->first('fax', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-3 control-label">@lang('admin/suppliers/table.email')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="email" id="email" value="{{{ Input::old('email', $supplier->email) }}}" />
                        {{ $errors->first('email', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
                <label for="url" class="col-md-3 control-label">@lang('admin/suppliers/table.url')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="url" id="url" value="{{{ Input::old('url', $supplier->url) }}}" />
                        {{ $errors->first('url', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>


            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-3 control-label">@lang('admin/suppliers/table.notes')</label>
                    <div class="col-md-6">
                        <input class="form-control" type="text" name="notes" id="notes" value="{{{ Input::old('notes', $supplier->notes) }}}" />
                        {{ $errors->first('notes', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>






        <!-- Form actions -->
        <div class="form-group">
        <label class="col-md-2 control-label"></label>
            <div class="col-md-7">
                @if ($supplier->id)
                <a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
                @else
                <a class="btn btn-link" href="{{ route('suppliers') }}">@lang('general.cancel')</a>
                @endif
                <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
            </div>
        </div>

</form>
<br><br><br><br>

</div>

    <!-- side address column -->
   <div class="col-md-3 col-xs-12 address pull-right">
        <br /><br />
        <h6>Have Some Haiku</h6>
        <p>Serious error.<br>
        All shortcuts have disappeared.<br>
        Screen. Mind. Both are blank.</p>


    </div>

</div>

@stop
