<!-- invoice_number -->
<div class="form-group {{ $errors->has('invoice_number') ? ' has-error' : '' }}">
    <label for="invoice_number" class="col-md-3 control-label">{{ $translated_name }}</label>
    <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($item, 'invoice_number')) ? ' required' : '' }}">
        <input class="form-control" type="text" name="invoice_number" aria-label="invoice_number" id="invoice_number" value="{{ Input::old('invoice_number', $item->invoice_number) }}" />
        {!! $errors->first('invoice_number', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>