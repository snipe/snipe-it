<div id="assigned_user" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}

    <div class="col-md-6">
        <select class="js-data-ajax" data-endpoint="departments" data-placeholder="{{ trans('general.select_department') }}" name="{{ $fieldname }}" style="width: 100%" id="department_select" aria-label="{{ $fieldname }}"{{ (isset($multiple) && ($multiple=='true')) ? " multiple='multiple'" : '' }}>
            @if ($department_id = old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $department_id }}" selected="selected" role="option" aria-selected="true"  role="option">
                    {{ (\App\Models\Department::find($department_id)) ? \App\Models\Department::find($department_id)->name : '' }}
                </option>
            @endif
        </select>
    </div>
    <x-form-error name=":$fieldname" />

</div>
