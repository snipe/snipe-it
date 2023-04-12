@extends('layouts/edit-form', [
    'createText' => trans('admin/manufacturers/table.create') ,
    'updateText' => trans('admin/manufacturers/table.update'),
    'helpTitle' => trans('admin/manufacturers/table.about_manufacturers_title'),
    'helpText' => trans('admin/manufacturers/table.about_manufacturers_text'),
    'formAction' => (isset($item->id)) ? route('manufacturers.update', ['manufacturer' => $item->id]) : route('manufacturers.store'),
])


{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/manufacturers/table.name')])
    <!-- URL -->
    <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
        <label for="url" class="col-md-3 control-label">{{ trans('admin/manufacturers/table.url') }}
        </label>
        <div class="col-md-6">
            <input class="form-control" type="text" name="url" id="url" value="{{ old('url', $item->url) }}" />
            {!! $errors->first('url', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>

    <!-- Support URL -->
    <div class="form-group {{ $errors->has('support_url') ? ' has-error' : '' }}">
        <label for="support_url" class="col-md-3 control-label">{{ trans('admin/manufacturers/table.support_url') }}
        </label>
        <div class="col-md-6">
            <input class="form-control" type="text" name="support_url" id="support_url" value="{{ old('support_url', $item->support_url) }}" />
            {!! $errors->first('support_url', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>

    <!-- Support Phone -->
    <div class="form-group {{ $errors->has('support_phone') ? ' has-error' : '' }}">
        <label for="support_phone" class="col-md-3 control-label">{{ trans('admin/manufacturers/table.support_phone') }}
        </label>
        <div class="col-md-6">
            <input class="form-control" type="text" name="support_phone" id="support_phone" value="{{ old('support_phone', $item->support_phone) }}" />
            {!! $errors->first('support_phone', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>

    <!-- Support Email -->
    <div class="form-group {{ $errors->has('support_email') ? ' has-error' : '' }}">
        <label for="support_email" class="col-md-3 control-label">{{ trans('admin/manufacturers/table.support_email') }}
        </label>
        <div class="col-md-6">
            <input class="form-control" type="email" name="support_email" id="support_email" value="{{ old('support_email', $item->support_email) }}" />
            {!! $errors->first('support_email', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>

@include ('partials.forms.edit.image-upload', ['image_path' => app('manufacturers_upload_path')])



@stop
