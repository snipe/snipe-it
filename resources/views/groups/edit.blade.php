@extends('layouts/edit-form', [
    'createText' => trans('admin/groups/titles.create') ,
    'updateText' => trans('admin/groups/titles.update'),
    'item' => $group,
    'formAction' => ($group !== null && $group->id !== null) ? route('groups.update', ['group' => $group->id]) : route('groups.store'),
    'topSubmit' => 'true',
])
@section('content')



@parent
@stop

@section('inputFields')

<!-- Name -->
<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-3 control-label">{{ trans('admin/groups/titles.group_name') }}</label>
    <div class="col-md-8 required">
        <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $group->name) }}" required />
        <x-form.error name="name" />
    </div>
</div>

<div class="form-group{!! $errors->has('notes') ? ' has-error' : '' !!}">
    <label for="notes" class="col-md-3 control-label">{{ trans('general.notes') }}</label>
    <div class="col-md-8">
        <x-input.textarea
                name="notes"
                id="notes"
                :value="old('notes', $group->notes)"
                placeholder="{{ trans('general.placeholders.notes') }}"
                aria-label="notes"
                rows="2"
        />

        <x-form.error name="notes" />
    </div>
</div>


<fieldset>
    <x-form.legend icon="warning" help_text="{{ trans('general.add_users_to_group_help') }}">
       {{ trans('general.add_users_to_group') }}
    </x-form.legend>

    <x-input.select2-checkboxes-scrollbox
        name="users_to_sync"
        :label="trans('general.users_to_add_to_group')"
        endpoint="users"
        :selected="$associated_user_ids"
        :compactSubmit="true"
    />
</fieldset>


<div class="col-md-12">
    @include ('partials.forms.edit.permissions-base', ['use_inherit' => false])
</div>
@stop

