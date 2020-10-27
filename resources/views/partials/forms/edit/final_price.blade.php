<!-- invoice_number -->
<div class="form-group {{ $errors->has('final_price') ? ' has-error' : '' }}">
    <label for="final_price" class="col-md-3 control-label">{{ $translated_name }}</label>
    <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($item, 'final_price')) ? ' required' : '' }}">
        <input class="form-control float" type="text"  name="final_price" aria-label="final_price" id="final_price" value="{{ Input::old('final_price', $item->final_price) }}" />
        {!! $errors->first('final_price', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>