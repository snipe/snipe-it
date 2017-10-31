<!-- Asset Model -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}

    <div class="col-md-7 required">
        <select class="js-data-ajax" data-endpoint="manufacturers" name="{{ $fieldname }}" style="width: 100%" id="category_select_id">
            @if ($manufacturer_id = Input::old($fieldname, $item->{$fieldname}))
                <option value="{{ $manufacturer_id }}" selected="selected">
                    {{ \App\Models\Manufacturer::find($manufacturer_id)->name }}
                </option>
            @else
                <option value="">{{ trans('general.select_manufacturer') }}</option>
            @endif

        </select>
    </div>


    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}
</div>
