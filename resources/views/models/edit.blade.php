@extends('layouts/edit-form', [
    'createText' => trans('admin/models/table.create') ,
    'updateText' => trans('admin/models/table.update'),
    'topSubmit' => true,
    'helpPosition' => 'right',
    'helpText' => trans('admin/models/general.about_models_text'),
    'formAction' => (isset($item->id)) ? route('models.update', ['model' => $item->id]) : route('models.store'),
])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/models/table.name'), 'required' => 'true'])
@include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id', 'required' => 'true'])
@include ('partials.forms.edit.category-select', ['translated_name' => trans('admin/categories/general.category_name'), 'fieldname' => 'category_id', 'required' => 'true', 'category_type' => 'asset'])
@include ('partials.forms.edit.model_number')
@include ('partials.forms.edit.depreciation')

<!-- EOL -->

<div class="form-group {{ $errors->has('eol') ? ' has-error' : '' }}">
    <label for="eol" class="col-md-3 control-label">{{ trans('general.eol') }}</label>
    <div class="col-md-2">
        <div class="input-group">
            <input class="col-md-1 form-control" type="text" name="eol" id="eol" value="{{ Request::old('eol', isset($item->eol)) ? $item->eol : ''  }}" />
            <span class="input-group-addon">
                {{ trans('general.months') }}
            </span>
        </div>
    </div>
    <div class="col-md-9 col-md-offset-3">
        {!! $errors->first('eol', '<span class="alert-msg" aria-hidden="true"><br><i class="fas fa-times"></i> :message</span>') !!}
    </div>
</div>

<!-- Custom Fieldset -->
@livewire('custom-field-set-default-values-for-model',["model_id" => $item->id])

@include ('partials.forms.edit.notes')
@include ('partials.forms.edit.requestable', ['requestable_text' => trans('admin/models/general.requestable')])

<!-- Image -->
@if (($item->image) && ($item->image!=''))
<div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
    <div class="col-md-5">
        <label for="image_delete">
            {{ Form::checkbox('image_delete', '1', old('image_delete'), array('class' => 'minimal', 'aria-label'=>'required')) }}
        </label>
        <br>
        <img src="{{ Storage::disk('public')->url(app('models_upload_path').e($item->image )) }}" alt="Image for {{ $item->name }}" class="img-responsive">
        {!! $errors->first('image_delete', '<span class="alert-msg" aria-hidden="true"><br>:message</span>') !!}
    </div>
</div>


@endif

@include ('partials.forms.edit.image-upload')

@stop