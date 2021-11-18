<!-- Holder -->
<!-- I will add data types once we chose what we want the values to be-->

<div class="form-group{{ $errors->has('holder') ? ' has-error' : '' }}">
    <label for="holder" class="col-md-3 control-label">{{ trans('CheckBoxes') }}</label>
    <div class="input-group col-md-3">
        <!--<div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">-->
            <!--<input type="checkbox" class="form-control" placeholder="{{ trans('general.select_date') }}" name="holder" id="holder" value="{{ old('holder', ($item->holder) ? $item->holder->format('Y-m-d') : '') }}">
            <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>-->

            <input type="checkbox" id="val1" name="val1" value="val1">
            <label for ="val1"> Value 1</label><br>
            <input type="checkbox" id="val2" name="val2" value="val2">
            <label for ="val1"> Value 2</label><br>
            <input type="checkbox" id="val3" name="val3" value="val3">
            <label for ="val1"> Value 3</label><br>

        </div>
        {!! $errors->first('Holder', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
    