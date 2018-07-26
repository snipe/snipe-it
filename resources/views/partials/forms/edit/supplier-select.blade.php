<div id="assigned_user" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}

    <div class="col-md-7{{  ((isset($required)) && ($required=='true')) ? ' required' : '' }}">
        <select class="js-data-ajax" data-endpoint="suppliers" data-placeholder="{{ trans('general.select_supplier') }}" name="{{ $fieldname }}" style="width: 100%" id="supplier_select">
            @if ($supplier_id = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $supplier_id }}" selected="selected">
                    {{ (\App\Models\Supplier::find($supplier_id)) ? \App\Models\Supplier::find($supplier_id)->name : '' }}
                </option>
            @else
                <option value="">{{ trans('general.select_supplier') }}</option>
            @endif
        </select>
    </div>

    <div class="col-md-1 col-sm-1 text-left">
        @can('create', \App\Models\Supplier::class)
            @if ((!isset($hide_new)) || ($hide_new!='true'))
                <a href='{{ route('modal.supplier') }}' data-toggle="modal"  data-target="#createModal" data-select='supplier_select' class="btn btn-sm btn-default">New</a>
            @endif
        @endcan
    </div>

    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>
