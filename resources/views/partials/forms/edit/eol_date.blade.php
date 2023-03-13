<!-- Purchase Date -->
<div class="form-group {{ $errors->has('asset_eol_date') ? ' has-error' : '' }}">
    <label for="asset_eol_date" class="col-md-3 control-label">{{ trans('admin/hardware/form.eol_date') }}</label>
    <div class="input-group col-md-4">
        <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="asset_eol_date" id="asset_eol_date" readonly value="{{  old('asset_eol_date', $item->asset_eol_date ?? $item->present()->eol_date() ?? '')  }}"  style="background-color:inherit">
            <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
        </div>
        {!! $errors->first('asset_eol_date', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
