<!-- Asset -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7 required">
        <select class="js-data-ajax" data-endpoint="hardware" name="{{ $fieldname }}" style="width: 100%" id="assigned_asset_select">
            @if (Input::old($fieldname))
                <option value="{{ Input::old($fieldname) }}" selected="selected">
                    {{ \App\Models\Asset::select('name')->find(Input::old($fieldname))->name }}
                </option>
            @endif
        </select>
    </div>
    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
