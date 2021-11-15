<!-- Declassification date -->
<div class="form-group{{ $errors->has('declassification_date') ? ' has-error' : '' }}">
    <label for="declassification_date" class="col-md-3 control-label">{{ trans('Declassification Date') }}</label>
    <div class="input-group col-md-3">
        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="declassification_date" id="declassification_date" value="{{ old('declassification_date', ($item->declassification_date) ? $item->declassification_date->format('Y-m-d') : '') }}">
            <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
        </div>
        {!! $errors->first('declassification_date', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>


