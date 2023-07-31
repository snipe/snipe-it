
<!-- QTY -->
<div class="form-group {{ $errors->has('qty') ? ' has-error' : '' }}">
    <label for="qty" class="col-md-3 control-label">{{ trans('general.quantity') }}</label>
    <div class="col-md-7{{  (Helper::checkIfRequired($item, 'qty')) ? ' required' : '' }}">
       <div class="col-md-3" style="padding-left:0px">
           <input class="form-control" type="text" name="qty" aria-label="qty" id="qty" value="{{ old('qty', $item->qty) }}" {!!  (Helper::checkIfRequired($item, 'qty')) ? ' data-validation="required" required' : '' !!}/>
       </div>
       {!! $errors->first('qty', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
   </div>
</div>
