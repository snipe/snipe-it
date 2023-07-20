@extends('layouts/edit-form', [
    'createText' => trans('admin/locations/table.create') ,
    'updateText' => trans('admin/locations/table.update'),
    'topSubmit' => true,
    'helpPosition' => 'right',
    'helpText' => trans('admin/locations/table.about_locations'),
    'formAction' => (isset($item->id)) ? route('locations.update', ['location' => $item->id]) : route('locations.store'),
])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/locations/table.name')])

<!-- parent -->
@include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/locations/table.parent'), 'fieldname' => 'parent_id'])

<!-- Manager-->
@include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/users/table.manager'), 'fieldname' => 'manager_id'])

@include ('partials.forms.edit.phone')
@include ('partials.forms.edit.fax')

<!-- Currency -->
<div class="form-group {{ $errors->has('currency') ? ' has-error' : '' }}">
    <label for="currency" class="col-md-3 control-label">
        {{ trans('admin/locations/table.currency') }}
    </label>
    <div class="col-md-9{{  (Helper::checkIfRequired($item, 'currency')) ? ' required' : '' }}">
        {{ Form::text('currency', old('currency', $item->currency), array('class' => 'form-control','placeholder' => 'USD', 'maxlength'=>'3', 'style'=>'width: 60px;', 'aria-label'=>'currency')) }}
        {!! $errors->first('currency', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.address')

<!-- LDAP Search OU -->
@if ($snipeSettings->ldap_enabled == 1)
    <div class="form-group {{ $errors->has('ldap_ou') ? ' has-error' : '' }}">
        <label for="ldap_ou" class="col-md-3 control-label">
            {{ trans('admin/locations/table.ldap_ou') }}
        </label>
        <div class="col-md-7{{  (Helper::checkIfRequired($item, 'ldap_ou')) ? ' required' : '' }}">
            {{ Form::text('ldap_ou', old('ldap_ou', $item->ldap_ou), array('class' => 'form-control')) }}
            {!! $errors->first('ldap_ou', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
        </div>
    </div>
@endif

@include ('partials.forms.edit.image-upload', ['image_path' => app('locations_upload_path')])
@stop

