@extends('layouts/edit-form', [
    'createText' =>  trans('admin/kits/general.create'),
    'updateText' => trans('admin/kits/general.update'),
    'formAction' => (isset($item->id)) ? route('kits.update', ['kit' => $item->id]) : route('kits.store'),
])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => trans('general.name')])
<div class="form-group">
    <label for="groups[]" class="col-md-3 control-label">{{ trans('general.groups') }}</label>
    <div class="col-md-7 col-sm-12 controls">
        <select
            name="groups[]"
            aria-label="groups[]"
            id="groups[]"
            multiple="multiple"
            class="form-control"
            data-validation="required">

            <option value="0">General</option>
            @foreach ($groups as $id => $group)
                <option value="{{ $id }}">
                    {{ $group }}
                </option>
            @endforeach
        </select>
    </div>
   </div>
@stop
