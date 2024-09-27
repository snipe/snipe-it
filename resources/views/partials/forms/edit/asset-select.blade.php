<!-- Asset -->
<div id="{{ isset($divname) ? $divname : 'assigned_asset' }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-8{{  ((isset($required) && ($required =='true'))) ?  ' required' : '' }}">
    
       
        <select class="js-data-ajax select2" data-endpoint="hardware" data-placeholder="{{ trans('general.select_asset') }}" aria-label="{{ $fieldname }}" name="{{ $fieldname }}" style="width: 100%" id="{{ $select_id = (isset($select_id)) ? $select_id : 'assigned_asset_select' }}"{{ (isset($multiple)) ? ' multiple' : '' }}{!! (!empty($asset_status_type)) ? ' data-asset-status-type="' . $asset_status_type . '"' : '' !!}>

            @if ((!isset($unselect)) && ($asset_id = old($fieldname, (isset($asset) ? $asset->id  : (isset($item) ? $item->{$fieldname} : '')))))
                <option value="{{ $asset_id }}" selected="selected" role="option" aria-selected="true"  role="option">
                    {{ (\App\Models\Asset::find($asset_id)) ? \App\Models\Asset::find($asset_id)->present()->fullName : '' }}
                </option>
            @else
                @if(!isset($multiple))
                    <option value=""  role="option">{{ trans('general.select_asset') }}</option>
                @endif
            @endif
        </select>
    </div>
    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span></div>') !!}

</div>

@section('moar_scripts')
    @parent

    @if (isset($assets) && isset($multiple))
    <script nonce="{{ csrf_token() }}">
        $(document).ready(function() {
            var assets = [];
            @foreach ($assets as $asset)
                assets.push(<?php echo $asset; ?>);
            @endforeach
            window.load_bulkassets("{{ $select_id }}", assets);
        });
    </script>
    @endif
@stop
