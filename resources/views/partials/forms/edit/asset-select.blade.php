<!-- Asset -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7 required">
        <select class="js-data-ajax select2" data-endpoint="hardware" name="{{ $fieldname }}" style="width: 100%" id="assigned_asset_select"{{ (isset($multiple)) ? ' multiple="multiple"' : '' }}>
            @if ($asset_id = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $asset_id }}" selected="selected">
                    {{ \App\Models\Asset::find($asset_id)->present()->fullName }}
                </option>
            @else
                <option value="">{{ trans('general.select_asset') }}</option>
            @endif
        </select>
    </div>
    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
