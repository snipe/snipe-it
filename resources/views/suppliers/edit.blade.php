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
@include ('partials.forms.edit.fax')
@include ('partials.forms.edit.email')

<div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
    {{ Form::label('url', trans('admin/suppliers/table.url'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('url', old('url', $item->url), array('class' => 'form-control')) }}
        {!! $errors->first('url', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.notes')
@include ('partials.forms.edit.image-upload', ['image_path' => app('suppliers_upload_path')])

@stop
