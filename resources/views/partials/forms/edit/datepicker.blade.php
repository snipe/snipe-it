<!-- Datepicker -->
<div class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="input-group col-md-4">
        <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="{{ $fieldname }}" id="{{ $fieldname }}" value="{{ old($fieldname, ($item->{$fieldname}) ? date('Y-m-d', strtotime($item->{$fieldname})) : '') }}" readonly style="background-color:inherit" maxlength="10">
            <span class="input-group-addon"><x-icon type="calendar" /></span>
        </div>
        {!! $errors->first($fieldname, '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

