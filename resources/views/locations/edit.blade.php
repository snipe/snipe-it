@extends('layouts/edit-form', [
    'createText' => trans('admin/locations/table.create') ,
    'updateText' => trans('admin/locations/table.update'),
    'helpTitle' => trans('admin/locations/table.about_locations_title'),
    'helpText' => trans('admin/locations/table.about_locations'),
    'formAction' => ($item) ? route('locations.update', ['location' => $item->id]) : route('locations.store'),
])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/locations/table.name')])

<!-- Parent-->
<div class="form-group {{ $errors->has('parent_id') ? ' has-error' : '' }}">
    <label for="parent_id" class="col-md-3 control-label">
        {{ trans('admin/locations/table.parent') }}
    </label>
    <div class="col-md-9{{  (\App\Helpers\Helper::checkIfRequired($item, 'parent_id')) ? ' required' : '' }}">
        {!! Form::select('parent_id', $location_options , Input::old('parent_id', $item->parent_id), array('class'=>'select2 parent', 'style'=>'width:350px')) !!}
        {!! $errors->first('parent_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<!-- Manager-->
@include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/users/table.manager'), 'fieldname' => 'manager_id'])

<!-- Currency -->
<div class="form-group {{ $errors->has('currency') ? ' has-error' : '' }}">
    <label for="currency" class="col-md-3 control-label">
        {{ trans('admin/locations/table.currency') }}
    </label>
    <div class="col-md-9{{  (\App\Helpers\Helper::checkIfRequired($item, 'currency')) ? ' required' : '' }}">
        {{ Form::text('currency', Input::old('currency', $item->currency), array('class' => 'form-control','placeholder' => 'USD', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}
        {!! $errors->first('currency', '<span class="alert-msg">:message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.address')

<!-- LDAP Search OU -->
@if ($snipeSettings->ldap_enabled == 1)
    <div class="form-group {{ $errors->has('ldap_ou') ? ' has-error' : '' }}">
        <label for="ldap_ou" class="col-md-3 control-label">
            {{ trans('admin/locations/table.ldap_ou') }}
        </label>
        <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'ldap_ou')) ? ' required' : '' }}">
            {{ Form::text('ldap_ou', Input::old('ldap_ou', $item->ldap_ou), array('class' => 'form-control')) }}
            {!! $errors->first('ldap_ou', '<span class="alert-msg">:message</span>') !!}
        </div>
    </div>
@endif

<!-- Image -->
@if ($item->image)
    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
        <div class="col-md-5">
            {{ Form::checkbox('image_delete') }}
            <img src="{{ url('/') }}/uploads/locations/{{ $item->image }}" />
            {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
        </div>
    </div>
@endif

@include ('partials.forms.edit.image-upload')
@stop

@if (!$item->id)
@section('moar_scripts')
<script nonce="{{ csrf_token() }}">

    var $eventSelect = $(".parent");
    $eventSelect.on("change", function () { parent_details($eventSelect.val()); });
    $(function() {
        var parent_loc = $(".parent option:selected").val();
        if(parent_loc!=''){
            parent_details(parent_loc);
        }
    });

    function parent_details(id) {

        if (id) {
//start ajax request
$.ajax({
    type: 'GET',
    url: "{{url('/') }}/api/locations/"+id+"/check",
//force to handle it as text
dataType: "text",
success: function(data) {
    var json = $.parseJSON(data);
    $("#city").val(json.city);
    $("#address").val(json.address);
    $("#address2").val(json.address2);
    $("#state").val(json.state);
    $("#zip").val(json.zip);
    $(".country").select2("val",json.country);
}
});
} else {
    $("#city").val('');
    $("#address").val('');
    $("#address2").val('');
    $("#state").val('');
    $("#zip").val('');
    $(".country").select2("val",'');
}



};
</script>
@stop
@endif
