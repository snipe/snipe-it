<div id="assigned_user" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}" style='margin-bottom:0px' >

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-4 col-xs-12')) }}

    <div class="col-md-8 col-xs-12">
        <select class="js-data-ajax" data-endpoint="departments" data-placeholder="{{ trans('general.select_department') }}" name="{{ $fieldname }}" style="width: 100%" id="department_select">
            @if ($department_id = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $department_id }}" selected="selected">
                    {{ (\App\Models\Department::find($department_id)) ? \App\Models\Department::find($department_id)->name : '' }}
                </option>
            @else
                <option value="">{{ trans('general.select_department') }}</option>
            @endif
        </select>
    </div>


    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
