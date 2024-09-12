<!-- partials/forms/edit/name-first.blade.php -->
<div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="first_name">{{ trans('general.first_name') }}</label>
    <div class="{{$class ? $class : 'col-md-6'}}" style= "{{$style ? $style : ''}}""{{  (Helper::checkIfRequired($user, 'first_name')) ? ' required' : '' }}">
        <input class="form-control" type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" maxlength="191" />
        {!! $errors->first('first_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>
</div>
<!-- partials/forms/edit/name-first.blade.php -->