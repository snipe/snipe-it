<div id="assigned_user" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}

    <div class="col-md-7{{  ((isset($required)) && ($required=='true')) ? ' required' : '' }}">
        <select class="js-data-ajax" data-endpoint="invoice_types" data-placeholder="Выберите тип счета" name="{{ $fieldname }}" style="width: 100%" id="invoice_type_select" aria-label="{{ $fieldname }}">
            @if ($invoice_type_id = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $invoice_type_id }}" selected="selected" role="option" aria-selected="true"  role="option">
                    {{ (\App\Models\InvoiceType::find($invoice_type_id)) ? \App\Models\InvoiceType::find($invoice_type_id)->name : '' }}
                </option>
            @else
                <option value=""  role="option">Выберите тип счета</option>
            @endif
        </select>
    </div>

    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span></div>') !!}

</div>
