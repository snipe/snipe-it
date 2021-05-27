<div id="kit_id" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}

    <div class="col-md-7{{  ((isset($required)) && ($required=='true')) ? ' required' : '' }}">
        <select class="js-data-ajax" data-endpoint="kits" data-placeholder="Select a kit{{-- TODO: trans --}}" name="{{ $fieldname }}" style="width: 100%" id="kit_id_select">
            @if ($kit_id = Request::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $kit_id }}" selected="selected">
                    {{ (\App\Models\User::find($kit_id)) ? \App\Models\User::find($kit_id)->present()->fullName : '' }}
                </option>
            @else
                <option value="">Select a kit{{-- TODO: trans --}}</option>
            @endif
        </select>
    </div>

    <div class="col-md-1 col-sm-1 text-left">
        @can('create', \App\Models\PredefinedKit::class)
            @if ((!isset($hide_new)) || ($hide_new!='true'))
                {{--  <a href='{{ route('modal.show, 'kit') }}' data-toggle="modal"  data-target="#createModal" data-select='kit_id_select' class="btn btn-sm btn-default">New</a>  --}}
            @endif
        @endcan
    </div>

    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
