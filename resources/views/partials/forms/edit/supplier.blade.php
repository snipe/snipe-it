<!-- Supplier -->
<div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
    <label for="supplier_id" class="col-md-3 control-label">{{ trans('general.supplier') }}</label>
    <div class="col-md-7">
        {{ Form::select('supplier_id', $supplier_list , old('supplier_id', $item->supplier_id), ['class'=>'select2', 'style'=>'min-width:350px', 'id' => 'supplier_select_id', 'required' => Helper::checkIfRequired($item, 'supplier_id') ? true : '']) }}
        {!! $errors->first('supplier_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
    <div class="col-md-1 col-sm-1 text-left">
             <a href='{{ route('modal.show', 'supplier') }}' data-toggle="modal"  data-target="#createModal" data-dependency="supplier" data-select='supplier_select_id' class="btn btn-sm btn-primary">{{  trans('button.new') }}</a>
    </div>
</div>
