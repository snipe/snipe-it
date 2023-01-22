@extends('layouts/edit-form', [
    'createText' => trans('admin/suppliers/table.create') ,
    'updateText' => trans('admin/suppliers/table.update'),
    'helpTitle' => trans('admin/suppliers/table.about_suppliers_title'),
    'helpText' => trans('admin/suppliers/table.about_suppliers_text'),
    'formAction' => (isset($item->id)) ? route('suppliers.update', ['supplier' => $item->id]) : route('suppliers.store'),
])


{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/suppliers/table.name')])
@include ('partials.forms.edit.address')

<div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
    {{ Form::label('contact', trans('admin/suppliers/table.contact'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('contact', old('contact', $item->contact), array('class' => 'form-control')) }}
        {!! $errors->first('contact', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.phone')

<div class="form-group {{ $errors->has('fax') ? ' has-error' : '' }}">
    {{ Form::label('fax', trans('admin/suppliers/table.fax'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('fax', old('fax', $item->fax), array('class' => 'form-control')) }}
        {!! $errors->first('fax', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.email')

<div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
    {{ Form::label('url', trans('admin/suppliers/table.url'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('url', old('url', $item->url), array('class' => 'form-control')) }}
        {!! $errors->first('url', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.notes')

<!-- Image -->
@if (($item->image) && ($item->image!=''))
    <div class="form-group{{ $errors->has('image_delete') ? ' has-error' : '' }}">
        <div class="col-md-9 col-md-offset-3">
            <label for="image_delete">
                {{ Form::checkbox('image_delete', '1', old('image_delete'), ['class'=>'minimal','aria-label'=>'image_delete']) }}
                {{ trans('general.image_delete') }}
                {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
            </label>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <img src="{{ Storage::disk('public')->url(app('suppliers_upload_path').e($item->image)) }}" class="img-responsive">
            {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
        </div>
    </div>
@endif

@include ('partials.forms.edit.image-upload')
@stop
