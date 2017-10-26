@extends('layouts/edit-form', [
    'createText' => trans('admin/departments/table.create') ,
    'updateText' => trans('admin/departments/table.update'),
    'helpTitle' => trans('admin/departments/table.about_locations_title'),
    'helpText' => trans('admin/departments/table.about_locations'),
    'formAction' => ($item) ? route('departments.update', ['department' => $item->id]) : route('departments.store'),
])

{{-- Page content --}}
@section('inputFields')

    @include ('partials.forms.edit.name', ['translated_name' => trans('admin/departments/table.name')])

    @include ('partials.forms.edit.company')

    <!-- Manager -->
    <div class="form-group {{ $errors->has('manager_id') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="manager_id">{{ trans('admin/users/table.manager') }}</label>
        <div class="col-md-8">
            {{ Form::select('manager_id', $manager_list , Input::old('manager_id', $item->manager_id), array('class'=>'select2', 'style'=>'width:350px')) }}
            {!! $errors->first('manager_id', '<span class="alert-msg">:message</span>') !!}
        </div>
    </div>

    <!-- Location -->
    <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
        <label class="col-md-3 control-label" for="location_id">{{ trans('admin/departments/table.location') }}
        </label>
        <div class="col-md-8">
            {{ Form::select('location_id', $location_list , Input::old('location_id', $item->location_id), array('class'=>'select2', 'style'=>'width:350px')) }}
            {!! $errors->first('location_id', '<span class="alert-msg">:message</span>') !!}
        </div>
    </div>

    <!-- Image -->
    @if ($item->image)
        <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
            <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
            <div class="col-md-5">
                {{ Form::checkbox('image_delete') }}
                <img src="{{ url('/') }}/uploads/departments/{{ $item->image }}" />
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

