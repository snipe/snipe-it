@if ($is_gd_installed)
    <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <label class="form-control" for="alt_barcode_enabled">
                <input type="checkbox" name="alt_barcode_enabled" id="alt_barcode_enabled" value="1" @checked(old('alt_barcode_enabled', $setting->alt_barcode_enabled))>
                {{ trans('admin/settings/general.display_alt_barcode') }}
            </label>
        </div>
    </div>
@endif

<div class="form-group{{ $errors->has('label2_1d_type') ? ' has-error' : '' }}">
    <div class="col-md-3 text-right">
        <label for="label2_1d_type" class="control-label">{{ trans('admin/settings/general.label2_1d_type') }}</label>
    </div>
    <div class="col-md-7">
        @php
            $select1DValues = [
                'C128'  => 'C128',
                'C39'   => 'C39',
                'EAN5'  => 'EAN5',
                'EAN13' => 'EAN13',
                'UPCA'  => 'UPCA',
                'UPCE'  => 'UPCE',
                'none'  => trans('admin/settings/general.none'),
            ];
        @endphp
        <x-input.select
            name="label2_1d_type"
            id="label2_1d_type"
            :options="$select1DValues"
            :selected="old('label2_1d_type', $setting->label2_1d_type)"
            class="col-md-4"
        />
        <x-form.error name="label2_1d_type" />
        <p class="help-block">
            {{ trans('admin/settings/general.label2_1d_type_help') }}.
            {!!
                trans('admin/settings/general.help_default_will_use', [
                    'default' => trans('admin/settings/general.default'),
                    'setting_name' => trans('admin/settings/general.barcodes').' &gt; '.trans('admin/settings/general.alt_barcode_type'),
                ])
            !!}
        </p>
    </div>
</div>

<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <label class="form-control" for="qr_code">
            <input type="checkbox" name="qr_code" id="qr_code" value="1" @checked(old('qr_code', $setting->qr_code))>
            {{ trans('admin/settings/general.display_qr') }}
        </label>
    </div>
</div>

<div class="form-group{{ $errors->has('label2_2d_type') ? ' has-error' : '' }}">
    <div class="col-md-3 text-right">
        <label for="label2_2d_type" class="control-label">{{ trans('admin/settings/general.label2_2d_type') }}</label>
    </div>
    <div class="col-md-7">
        @php
            $select2DValues = [
                'QRCODE' => 'QRCODE',
                'DATAMATRIX' => 'DATAMATRIX',
                'none' => trans('admin/settings/general.none'),
            ];
        @endphp
        <x-input.select
            name="label2_2d_type"
            id="label2_2d_type"
            :options="$select2DValues"
            :selected="old('label2_2d_type', $setting->label2_2d_type)"
            class="col-md-4"
        />
        <x-form.error name="label2_2d_type" />
        <p class="help-block">
            {{ trans('admin/settings/general.label2_2d_type_help', ['current' => $setting->barcode_type]) }}.
            {!! trans('admin/settings/general.help_default_will_use') !!}
        </p>
    </div>
</div>

<div class="form-group{{ $errors->has('qr_text') ? ' has-error' : '' }}">
    <div class="col-md-3 text-right">
        <label for="qr_text" class="control-label">{{ trans('admin/settings/general.qr_text') }}</label>
    </div>
    <div class="col-md-7">
        @if ($setting->qr_code == 1)
            <input
                class="form-control"
                placeholder="Property of Your Company"
                rel="txtTooltip"
                title="Extra text that you would like to display on your labels."
                data-toggle="tooltip"
                data-placement="top"
                name="qr_text"
                type="text"
                id="qr_text"
                value="{{ old('qr_text', $setting->qr_text) }}"
            >
        @else
            <input
                class="form-control"
                disabled="disabled"
                placeholder="Property of Your Company"
                name="qr_text"
                type="text"
                id="qr_text"
                value="{{ old('qr_text', $setting->qr_text) }}"
            >
            <p class="help-block">{{ trans('admin/settings/general.qr_help') }}</p>
        @endif

        <x-form.error name="qr_text" />
    </div>
</div>

<div class="form-group">
    <div class="col-md-3 text-right">
        <label for="purge_barcodes" class="control-label">{{ trans('admin/settings/general.purge_barcodes') }}</label>
    </div>
    <div class="col-md-7">
        <a class="btn btn-theme btn-sm pull-left" id="purgebarcodes" style="margin-right: 10px;">
            {{ trans('admin/settings/general.barcode_delete_cache') }}
        </a>
        <span id="purgebarcodesicon"></span>
        <span id="purgebarcodesresult"></span>
        <span id="purgebarcodesstatus"></span>
        <x-form.error name="purgebarcodes" />
        <p class="help-block">{{ trans('admin/settings/general.barcodes_help') }}</p>
    </div>
</div>

<div class="form-group{{ $errors->has('labels_per_page') ? ' has-error' : '' }}">
    <div class="col-md-3 text-right">
        <label for="labels_per_page" class="control-label">{{ trans('admin/settings/general.labels_per_page') }}</label>
    </div>
    <div class="col-md-9">
        <input class="form-control" style="width: 100px;" name="labels_per_page" type="text" value="{{ old('labels_per_page', $setting->labels_per_page) }}" id="labels_per_page">
        <x-form.error name="labels_per_page" />
    </div>
</div>

<div class="form-group{{ $errors->has('labels_fontsize') ? ' has-error' : '' }}">
    <div class="col-md-3 text-right">
        <label for="labels_fontsize" class="control-label">{{ trans('admin/settings/general.labels_fontsize') }}</label>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <input class="form-control" name="labels_fontsize" type="text" value="{{ old('labels_fontsize', $setting->labels_fontsize) }}" id="labels_fontsize">
            <div class="input-group-addon">{{ trans('admin/settings/general.text_pt') }}</div>
        </div>
    </div>
    <div class="col-md-9 col-md-offset-3">
        <x-form.error name="labels_fontsize" />
    </div>
</div>

<div class="form-group{{ $errors->has('labels_width') ? ' has-error' : '' }}">
    <div class="col-md-3 text-right">
        <label for="labels_width" class="control-label">{{ trans('admin/settings/general.label_dimensions') }}</label>
    </div>
    <div class="col-md-3 text-right">
        <div class="input-group">
            <input class="form-control" name="labels_width" type="text" value="{{ old('labels_width', $setting->labels_width) }}" id="labels_width">
            <div class="input-group-addon">{{ trans('admin/settings/general.width_w') }}</div>
        </div>
        <x-form.error name="labels_width" />
    </div>
    <div class="col-md-3 text-right">
        <div class="input-group">
            <input class="form-control" name="labels_height" type="text" value="{{ old('labels_height', $setting->labels_height) }}" id="labels_height">
            <div class="input-group-addon">{{ trans('admin/settings/general.height_h') }}</div>
        </div>
        <x-form.error name="labels_height" />
    </div>
</div>

<div class="form-group{{ $errors->has('labels_display_sgutter') ? ' has-error' : '' }}">
    <div class="col-md-3 text-right">
        <label for="labels_display_sgutter">{{ trans('admin/settings/general.label_gutters') }}</label>
    </div>
    <div class="col-md-3 text-right">
        <div class="input-group">
            <input class="form-control" name="labels_display_sgutter" type="text" value="{{ old('labels_display_sgutter', $setting->labels_display_sgutter) }}" id="labels_display_sgutter">
            <div class="input-group-addon">{{ trans('admin/settings/general.horizontal') }}</div>
        </div>
    </div>
    <div class="col-md-3 text-right">
        <div class="input-group">
            <input class="form-control" name="labels_display_bgutter" type="text" value="{{ old('labels_display_bgutter', $setting->labels_display_bgutter) }}" id="labels_display_bgutter">
            <div class="input-group-addon">{{ trans('admin/settings/general.vertical') }}</div>
        </div>
    </div>
    <div class="col-md-9 col-md-offset-3">
        <x-form.error name="labels_display_sgutter" />
        <x-form.error name="labels_display_bgutter" />
    </div>
</div>

<div class="form-group{{ $errors->has('labels_pmargin_top') ? ' has-error' : '' }}">
    <div class="col-md-3 text-right">
        <label for="labels_pmargin_top">{{ trans('admin/settings/general.page_padding') }}</label>
    </div>
    <div class="col-md-3 text-right">
        <div class="input-group" style="margin-bottom: 15px;">
            <input class="form-control" name="labels_pmargin_top" type="text" value="{{ old('labels_pmargin_top', $setting->labels_pmargin_top) }}" id="labels_pmargin_top">
            <div class="input-group-addon">{{ trans('admin/settings/general.top') }}</div>
        </div>
        <div class="input-group">
            <input class="form-control" name="labels_pmargin_right" type="text" value="{{ old('labels_pmargin_right', $setting->labels_pmargin_right) }}" id="labels_pmargin_right">
            <div class="input-group-addon">{{ trans('admin/settings/general.right') }}</div>
        </div>
    </div>
    <div class="col-md-3" style="margin-left: 10px;">
        <div class="input-group" style="margin-bottom: 15px;">
            <input class="form-control" name="labels_pmargin_bottom" type="text" value="{{ old('labels_pmargin_bottom', $setting->labels_pmargin_bottom) }}" id="labels_pmargin_bottom">
            <div class="input-group-addon">{{ trans('admin/settings/general.bottom') }}</div>
        </div>
        <div class="input-group">
            <input class="form-control" name="labels_pmargin_left" type="text" value="{{ old('labels_pmargin_left', $setting->labels_pmargin_left) }}" id="labels_pmargin_left">
            <div class="input-group-addon">{{ trans('admin/settings/general.left') }}</div>
        </div>
    </div>
</div>

<div class="form-group{{ (($errors->has('labels_pageheight')) || $errors->has('labels_pagewidth')) ? ' has-error' : '' }}">
    <div class="col-md-3 text-right">
        <label for="labels_pagewidth" class="control-label">{{ trans('admin/settings/general.page_dimensions') }}</label>
    </div>
    <div class="col-md-3 text-right">
        <div class="input-group">
            <input class="form-control" name="labels_pagewidth" type="text" value="{{ old('labels_pagewidth', $setting->labels_pagewidth) }}" id="labels_pagewidth">
            <div class="input-group-addon">{{ trans('admin/settings/general.width_w') }}</div>
        </div>
    </div>
    <div class="col-md-3 form-group" style="margin-left: 10px">
        <div class="input-group">
            <input class="form-control" name="labels_pageheight" type="text" value="{{ old('labels_pageheight', $setting->labels_pageheight) }}" id="labels_pageheight">
            <div class="input-group-addon">{{ trans('admin/settings/general.height_h') }}</div>
        </div>
    </div>
    <div class="col-md-9 col-md-offset-3">
        <x-form.error name="labels_pagewidth" />
        <x-form.error name="labels_pageheight" />
    </div>
</div>

<fieldset name="legacy-label-fields">
    <x-form.legend>
        {{ trans('admin/settings/general.label_fields') }}
    </x-form.legend>
    <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <label class="form-control" for="labels_display_name">
                <input type="checkbox" name="labels_display_name" id="labels_display_name" value="1" @checked(old('labels_display_name', $setting->labels_display_name))>
                {{ trans('admin/hardware/form.name') }}
            </label>
            <label class="form-control" for="labels_display_serial">
                <input type="checkbox" name="labels_display_serial" id="labels_display_serial" value="1" @checked(old('labels_display_serial', $setting->labels_display_serial))>
                {{ trans('admin/hardware/form.serial') }}
            </label>
            <label class="form-control" for="labels_display_tag">
                <input type="checkbox" name="labels_display_tag" id="labels_display_tag" value="1" @checked(old('labels_display_tag', $setting->labels_display_tag))>
                {{ trans('admin/hardware/form.tag') }}
            </label>
            <label class="form-control" for="labels_display_model">
                <input type="checkbox" name="labels_display_model" id="labels_display_model" value="1" @checked(old('labels_display_model', $setting->labels_display_model))>
                {{ trans('admin/hardware/form.model') }}
            </label>
            <label class="form-control" for="labels_display_company_name">
                <input type="checkbox" name="labels_display_company_name" id="labels_display_company_name" value="1" @checked(old('labels_display_company_name', $setting->labels_display_company_name))>
                {{ trans('admin/companies/table.name') }}
            </label>
        </div>
    </div>
</fieldset>


