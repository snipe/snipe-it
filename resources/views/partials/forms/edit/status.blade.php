<!-- Status -->
<div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
    <label for="status_id" class="col-md-3 control-label">{{ trans('admin/hardware/form.status') }}</label>
    <div class="col-md-7 col-sm-11">
        <x-input.select
            name="status_id"
            id="status_select_id"
            :options="$statuslabel_list"
            :selected="old('status_id', $item->status_id)"
            :required="$required"
            class="status_id"
            style="width:100%;"
            aria-label="status_id"
        />
        <x-form.error name="status_id" />
    </div>
    <div class="col-md-2 col-sm-2 text-left">

        @can('create', \App\Models\Statuslabel::class)
            <x-button.modal-add type="statuslabel" target="status_select_id"/>
        @endcan

        <span class="status_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fas fa-spinner fa-spin" aria-hidden="true"></i> </span>

    </div>

    <div class="col-md-7 col-sm-11 col-md-offset-3" id="status_helptext">
        <p id="selected_status_status" role="status" aria-live="polite" aria-atomic="true" style="display:none;"></p>
    </div>

</div>
