@extends('layouts/edit-form', [
    'createText' => trans('admin/categories/general.create') ,
    'updateText' => trans('admin/categories/general.update'),
    'helpTitle' =>  trans('admin/categories/general.about_categories_title'),
    'helpText' => trans('admin/categories/general.about_categories'),
    'formAction' => ($item) ? route('categories.update', ['category' => $item->id]) : route('categories.store'),
])

@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/categories/general.name')])

<!-- Type -->
<div class="form-group {{ $errors->has('category_type') ? ' has-error' : '' }}">
    <label for="category_type" class="col-md-3 control-label">{{ trans('general.type') }}</label>
    <div class="col-md-7 required">
        {{ Form::select('category_type', $category_types , Input::old('category_type', $item->category_type), array('class'=>'select2', 'style'=>'min-width:350px', $item->itemCount() > 0 ? 'disabled' : '')) }}
        {!! $errors->first('category_type', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<!-- EULA text -->
<div class="form-group {{ $errors->has('eula_text') ? 'error' : '' }}">
    <label for="eula_text" class="col-md-3 control-label">{{ trans('admin/categories/general.eula_text') }}</label>
    <div class="col-md-7">
        {{ Form::textarea('eula_text', Input::old('eula_text', $item->eula_text), array('class' => 'form-control')) }}
        <p class="help-block">{!! trans('admin/categories/general.eula_text_help') !!} </p>
        <p class="help-block">{!! trans('admin/settings/general.eula_markdown') !!} </p>

        {!! $errors->first('eula_text', '<span class="alert-msg">:message</span>') !!}
    </div>
</div>

<!-- Use default checkbox -->
<div class="checkbox col-md-offset-3">
    <label>

        @if ($snipeSettings->default_eula_text!='')
        {{ Form::checkbox('use_default_eula', '1', Input::old('use_default_eula', $item->use_default_eula)) }}
        {!! trans('admin/categories/general.use_default_eula') !!}
        @else
        {{ Form::checkbox('use_default_eula', '0', Input::old('use_default_eula'), array('disabled' => 'disabled')) }}
        {!! trans('admin/categories/general.use_default_eula_disabled') !!}
        @endif

    </label>
</div>

<!-- Require Acceptance -->
<div class="checkbox col-md-offset-3">
    <label>
        {{ Form::checkbox('require_acceptance', '1', Input::old('require_acceptance', $item->require_acceptance)) }}
        {{ trans('admin/categories/general.require_acceptance') }}
    </label>
</div>

<!-- Email on Checkin -->
<div class="checkbox col-md-offset-3">
    <label>
        {{ Form::checkbox('checkin_email', '1', Input::old('checkin_email', $item->checkin_email)) }}
        {{ trans('admin/categories/general.checkin_email') }}
    </label>
</div>

<!-- Image -->
@if ($item->image)
    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
        <div class="col-md-5">
            {{ Form::checkbox('image_delete') }}
            <img src="{{ url('/') }}/uploads/categories/{{ $item->image }}" />
            {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
        </div>
    </div>
@endif

<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
    <div class="col-md-5">
        {{ Form::file('image') }}
        {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
    </div>
</div>

@stop

@section('content')
@parent


@if ($snipeSettings->default_eula_text!='')
<!-- Modal -->
<div class="modal fade" id="eulaModal" tabindex="-1" role="dialog" aria-labelledby="eulaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="eulaModalLabel">{{ trans('admin/settings/general.default_eula_text') }}</h4>
            </div>
            <div class="modal-body">
                {{ \App\Models\Setting::getDefaultEula() }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@endif



@stop
