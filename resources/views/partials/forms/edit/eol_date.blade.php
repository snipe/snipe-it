<!-- EOL Date -->
<div class="form-group {{ $errors->has('asset_eol_date') ? ' has-error' : '' }}">
    <label for="asset_eol_date" class="col-md-3 control-label">{{ trans('admin/hardware/form.eol_date') }}</label>
    <div class="col-md-1 control-label">
        <input type="checkbox" value="1" name="eol_explicit" id="eol_explicit_active" {{ old('eol_explicit', $item->eol_explicit) == '1' ? ' checked="checked"' : '' }}>
    </div>
    <div class="input-group col-md-4" id="eol_date_row">
        <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="asset_eol_date" id="asset_eol_date" readonly value="{{  old('asset_eol_date', optional($item->asset_eol_date)->format('Y-m-d') ?? $item->asset_eol_date ?? '') }}"  style="background-color:inherit" /> 
            <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
        </div>
        {!! $errors->first('asset_eol_date', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
    <p class="col-md-7 col-md-offset-3 help-block">{{ trans('general.eol_date_help') }}</p>
</div>
