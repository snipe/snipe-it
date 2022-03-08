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
        {{ Form::select('category_type', $category_types , old('category_type', $item->category_type), array('class'=>'select2', 'style'=>'min-width:350px', 'aria-label'=>'category_type', $item->itemCount() > 0 ? 'disabled' : '')) }}
        {!! $errors->first('category_type', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
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
    <div class="col-md-3">
    </div>
    <div class="col-md-9">
        @if ($snipeSettings->default_eula_text!='')
            <label for="use_default_eula">
            {{ Form::checkbox('use_default_eula', '1', old('use_default_eula', $item->use_default_eula), ['class'=>'minimal', 'aria-label'=>'use_default_eula']) }}
            {!! trans('admin/categories/general.use_default_eula') !!}
            </label>
        @else
            <div class="icheckbox disabled">
                <label for="use_default_eula">
                {{ Form::checkbox('use_default_eula', '0', old('use_default_eula'), ['class'=>'disabled minimal','disabled' => 'disabled', 'aria-label'=>'use_default_eula']) }}
                {!! trans('admin/categories/general.use_default_eula_disabled') !!}
                </label>
            </div>
        @endif
    </div>
</div>


<!-- Require Acceptance -->
<div class="form-group">
    <div class="col-md-3">
    </div>
    <div class="col-md-9">
        <label for="require_acceptance">
        {{ Form::checkbox('require_acceptance', '1', old('require_acceptance', $item->require_acceptance), ['class'=>'minimal', 'aria-label'=>'require_acceptance']) }}
        {{ trans('admin/categories/general.require_acceptance') }}
        </label>
    </div>
</div>


<!-- Email on Checkin -->
<div class="form-group">
    <div class="col-md-3">
    </div>
    <div class="col-md-9">
        <label for="checkin_email">
        {{ Form::checkbox('checkin_email', '1', old('checkin_email', $item->checkin_email), ['class'=>'minimal','aria-label'=>'checkin_email']) }}
        {{ trans('admin/categories/general.checkin_email') }}
        </label>
    </div>
</div>



<!-- Image -->
@if ($item->image)
    <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
        <div class="col-md-9">
            {{ Form::checkbox('image_delete') }}
            <img src="{{ Storage::disk('public')->url(app('categories_upload_path').e($item->image)) }}" class="img-responsive" />
            {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
        </div>
    </div>
@endif

@include ('partials.forms.edit.image-upload')

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
