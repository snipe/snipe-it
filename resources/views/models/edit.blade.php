@extends('layouts/edit-form', [
    'createText' => trans('admin/models/table.create') ,
    'updateText' => trans('admin/models/table.update'),
    'helpTitle' => trans('admin/models/general.about_models_title'),
    'helpText' => trans('admin/models/general.about_models_text'),
    'formAction' => ($item) ? route('models.update', ['model' => $item->id]) : route('models.store'),
])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/models/table.name')])
@include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id', 'required' => 'true'])
@include ('partials.forms.edit.category-select', ['translated_name' => trans('admin/categories/general.category_name'), 'fieldname' => 'category_id', 'required' => 'true', 'category_type' => 'asset'])
@include ('partials.forms.edit.model_number')
@include ('partials.forms.edit.depreciation')

<!-- EOL -->

<div class="form-group {{ $errors->has('eol') ? ' has-error' : '' }}">
    <label for="eol" class="col-md-3 control-label">{{ trans('general.eol') }}</label>
    <div class="col-md-2">
        <div class="input-group">
            <input class="col-md-1 form-control" type="text" name="eol" id="eol" value="{{ Input::old('eol', isset($item->eol)) ? $item->eol : ''  }}" />
            <span class="input-group-addon">
                {{ trans('general.months') }}
            </span>
        </div>
    </div>
    <div class="col-md-9 col-md-offset-3">
        {!! $errors->first('eol', '<span class="alert-msg"><br><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<!-- Custom Fieldset -->
<div id="app">
    <div class="form-group {{ $errors->has('custom_fieldset') ? ' has-error' : '' }}">
        <label for="custom_fieldset" class="col-md-3 control-label">{{ trans('admin/models/general.fieldset') }}</label>
        <div class="col-md-7">
            {{ Form::select('custom_fieldset', \App\Helpers\Helper::customFieldsetList(),Input::old('custom_fieldset', $item->fieldset_id), array('class'=>'select2 js-fieldset-field', 'style'=>'width:350px')) }}
            {!! $errors->first('custom_fieldset', '<span class="alert-msg"><br><i class="fa fa-times"></i> :message</span>') !!}
            <label class="m-l-xs">
                {{ Form::checkbox('add_default_values', 1, Input::old('add_default_values'), ['class' => 'js-default-values-toggler']) }}
                {{ trans('admin/models/general.add_default_values') }}
            </label>
        </div>
    </div>

    <fieldset-default-values
        model-id="{{ $item->id ?: '' }}"
        fieldset-id="{{ !empty($item->fieldset) ? $item->fieldset->id : Input::old('custom_fieldset') }}"
        previous-input="{{ json_encode(Input::old('default_values')) }}">
    </fieldset-default-values>
</div>

@include ('partials.forms.edit.notes')
@include ('partials.forms.edit.requestable', ['requestable_text' => trans('admin/models/general.requestable')])

<!-- Image -->
@if ($item->image)
<div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
    <div class="col-md-5">
        {{ Form::checkbox('image_delete') }}
        <img src="{{ url('/') }}/uploads/models/{{ $item->image }}" />
        {!! $errors->first('image_delete', '<span class="alert-msg"><br>:message</span>') !!}
    </div>
</div>
@endif

@include ('partials.forms.edit.image-upload')

@stop

@section('moar_scripts')
<script nonce="{{ csrf_token() }}">
    new Vue({
        el: '#app'
    });
</script>
@endsection
