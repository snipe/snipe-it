<!-- Datepicker -->
<div class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="input-group col-md-3">
        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="{{ $fieldname }}" id="{{ $fieldname }}" value="{{ old($fieldname, ($item->{$fieldname}) ? $item->{$fieldname}->format('Y-m-d') : '') }}">
            <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
        </div>
        {!! $errors->first($fieldname, '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

