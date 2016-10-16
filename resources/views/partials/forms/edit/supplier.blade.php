<!-- Supplier -->
<div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
    <label for="supplier_id" class="col-md-3 control-label">{{ trans('general.supplier') }}</label>
    <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'supplier_id')) ? ' required' : '' }}">
        {{ Form::select('supplier_id', $supplier_list , Input::old('supplier_id', $item->supplier_id), ['class'=>'select2', 'style'=>'min-width:350px']) }}
        {!! $errors->first('supplier_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
    <div class="col-md-1 col-sm-1 text-left">
             <a href='#' data-toggle="modal"  data-target="#createModal" data-dependency="supplier" data-select='supplier_select_id' class="btn btn-sm btn-default">New</a>
    </div>
</div>
