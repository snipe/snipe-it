@extends('layouts/edit-form', [
    'createText' => trans('admin/groups/titles.create') ,
    'updateText' => trans('admin/groups/titles.update'),
    'item' => $group,
    'formAction' => ($group !== null && $group->id !== null) ? route('groups.update', ['group' => $group->id]) : route('groups.store'),

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
        <i class='fa fa-asterisk'></i>
    </label>
    <div class="col-md-6 required">
        <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $group->name) }}" />
        {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>


    @foreach ($permissions as $area => $permission)
        @for ($i = 0; $i < count($permission); $i++)


            <?php
            $permission_name = $permission[$i]['permission'];
            ?>
            @if ($permission[$i]['display'])
                <div class="col-md-9 col-md-offset-2">
                    <h3>{{ $area }}: {{ $permission[$i]['label'] }}</h3>
                    <p>{{ $permission[$i]['note'] }}</p>

                    <!-- radio -->
                        <div class="form-group" style="padding-left: 15px;">
                        <label class="radio-padding col-md-3">
                            {{ Form::radio('permission['.$permission_name.']', 1,
                            (is_array($groupPermissions))
                            && (array_key_exists($permission_name, $groupPermissions)
                            && $groupPermissions[$permission_name]), ['class' => 'minimal']) }}
                            Grant
                        </label>
                        <label class="radio-padding col-md-3">
                            {{ Form::radio('permission['.$permission_name.']', 0, ((is_array($groupPermissions) && !array_key_exists($permission_name, $groupPermissions)) || !$groupPermissions[$permission_name]), ['class' => 'minimal']) }}
                            Deny
                        </label>

                    </div>
                    <hr>
            </div>

            @endif
        @endfor
    @endforeach


@stop
