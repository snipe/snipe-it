@extends('layouts/edit-form', [
    'createText' => trans('admin/suppliers/table.create') ,
    'updateText' => trans('admin/suppliers/table.update'),
    'helpTitle' => trans('admin/suppliers/table.about_suppliers_title'),
    'helpText' => trans('admin/suppliers/table.about_suppliers_text'),
    'formAction' => ($item) ? route('suppliers.update', ['supplier' => $item->id]) : route('suppliers.store'),
])


{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/suppliers/table.name')])
@include ('partials.forms.edit.address')

<div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
    {{ Form::label('contact', trans('admin/suppliers/table.contact'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('contact', Input::old('contact', $item->contact), array('class' => 'form-control')) }}
        {!! $errors->first('contact', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.phone')

<div class="form-group {{ $errors->has('fax') ? ' has-error' : '' }}">
    {{ Form::label('fax', trans('admin/suppliers/table.fax'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('fax', Input::old('fax', $item->fax), array('class' => 'form-control')) }}
        {!! $errors->first('fax', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.email')

<div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
    {{ Form::label('url', trans('admin/suppliers/table.url'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('url', Input::old('url', $item->url), array('class' => 'form-control')) }}
        {!! $errors->first('url', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.notes')

<!-- Image -->
@if ($item->image)

<div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
    <div class="col-md-5">
        {{ Form::checkbox('image_delete') }}
        <img src="{{ url('/') }}/uploads/suppliers/{{ $item->image }}" />
        {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
    </div>
</div>
@endif

<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
    <div class="col-md-5">
        <label class="btn btn-default">
            {{ trans('button.select_file')  }}
            <input type="file" name="image" accept="image/gif,image/jpeg,image/png,image/svg" hidden>
        </label>
        <p class="help-block">Accepted filetypes are jpg, png, gif and svg</p>
        {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
    </div>
</div>

@stop
