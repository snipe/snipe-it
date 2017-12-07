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

    <!-- Company -->
    @if (\App\Models\Company::canManageUsersCompanies())
        @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
    @endif


    <!-- Manager -->
    @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/users/table.manager'), 'fieldname' => 'manager_id'])

    <!-- Location -->
    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])

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

    @include ('partials.forms.edit.image-upload')

@stop

