@extends('layouts/edit-form', [
    'createText' => trans('admin/categories/general.create') ,
    'updateText' => trans('admin/categories/general.update'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.categories'),
    'topSubmit'  => 'true',
    'formAction' => (isset($item->id)) ? route('categories.update', ['category' => $item->id]) : route('categories.store'),
])

@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/categories/general.name')])

<!-- Type -->
<div class="form-group {{ $errors->has('category_type') ? ' has-error' : '' }}">
    <label for="category_type" class="col-md-3 control-label">{{ trans('general.type') }}</label>
    <div class="col-md-7 required">
        {{ Form::select('category_type', $category_types , old('category_type', $item->category_type), array('class'=>'select2', 'style'=>'min-width:350px', 'aria-label'=>'category_type', ($item->category_type!='') || ($item->itemCount() > 0) ? 'disabled' : '')) }}
        {!! $errors->first('category_type', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
    <div class="col-md-7 col-md-offset-3">
        <p class="help-block">{!! trans('admin/categories/message.update.cannot_change_category_type') !!} </p>
    </div>
</div>



<!-- EULA text -->
<div class="form-group {{ $errors->has('eula_text') ? 'error' : '' }}">
    <label for="eula_text" class="col-md-3 control-label">{{ trans('admin/categories/general.eula_text') }}</label>
    <div class="col-md-7">
        {{ Form::textarea('eula_text', old('eula_text', $item->eula_text), array('class' => 'form-control', 'aria-label'=>'eula_text')) }}
        <p class="help-block">{!! trans('admin/categories/general.eula_text_help') !!} </p>
        <p class="help-block">{!! trans('admin/settings/general.eula_markdown') !!} </p>

        {!! $errors->first('eula_text', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>
</div>

<!-- Use default checkbox -->
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        @if ($snipeSettings->default_eula_text!='')
            <label class="form-control">
                {{ Form::checkbox('use_default_eula', '1', old('use_default_eula', $item->use_default_eula), ['aria-label'=>'use_default_eula']) }}
                <span>{!! trans('admin/categories/general.use_default_eula') !!}</span>
            </label>
        @else
            <label class="form-control form-control--disabled">
                {{ Form::checkbox('use_default_eula', '0', old('use_default_eula'), ['class'=>'disabled','disabled' => 'disabled', 'aria-label'=>'use_default_eula']) }}
                <span>{!! trans('admin/categories/general.use_default_eula_disabled') !!}</span>
            </label>
        @endif
    </div>
</div>


<!-- Require Acceptance -->
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <label class="form-control">
        {{ Form::checkbox('require_acceptance', '1', old('require_acceptance', $item->require_acceptance), ['aria-label'=>'require_acceptance']) }}
        {{ trans('admin/categories/general.require_acceptance') }}
        </label>
    </div>
</div>


<!-- Email on Checkin -->
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <label class="form-control">
        {{ Form::checkbox('checkin_email', '1', old('checkin_email', $item->checkin_email), ['aria-label'=>'checkin_email']) }}
        {{ trans('admin/categories/general.checkin_email') }}
        </label>
    </div>
</div>


@include ('partials.forms.edit.image-upload', ['image_path' => app('categories_upload_path')])


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
                <h2 class="modal-title" id="eulaModalLabel">{{ trans('admin/settings/general.default_eula_text') }}</h2>
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
