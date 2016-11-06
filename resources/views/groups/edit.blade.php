@extends('layouts/edit-form', [
    'createText' => trans('admin/groups/titles.create') ,
    'updateText' => trans('admin/groups/titles.update'),
    'helpTitle' => trans('admin/groups/general.about_groups_title'),
    'helpText' => trans('admin/groups/general.about_groups_text'),
    'item' => $group
])
@section('content')
<style>
    label.radio-padding {
        margin-right: 25px;
    }
</style>
@parent
@stop

@section('inputFields')
<!-- Name -->
<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-3 control-label">{{ trans('admin/groups/titles.group_name') }}
        <i class='fa fa-asterisk'></i></label>
        <div class="col-md-6 required">
            <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $group->name) }}" />
            {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
        </div>
    </div>

    <div class="col-md-8 col-md-offset-3">

        @foreach ($permissions as $area => $permission)
            @for ($i = 0; $i < count($permission); $i++)
            <?php
            $permission_name = $permission[$i]['permission'];
            ?>
                @if ($permission[$i]['display'])
                <h3>{{ $area }}: {{ $permission[$i]['label'] }}</h3>
                <p>{{ $permission[$i]['note'] }}</p>

                <!-- radio -->
                <div class="form-group" style="padding-left: 15px;">

                    <label class="radio-padding">
                        {{ Form::radio('permission['.$permission_name.']', 1,
                        (array_key_exists($permission_name, $groupPermissions) && $groupPermissions[$permission_name]), ['class' => 'minimal']) }}
                        Grant
                    </label>

                    <label class="radio-padding">
                        {{ Form::radio('permission['.$permission_name.']', 0, (!array_key_exists($permission_name, $groupPermissions) || !$groupPermissions[$permission_name]), ['class' => 'minimal']) }}
                        Deny
                    </label>
                </div>
                <hr>
                @endif
            @endfor
        @endforeach
@stop
