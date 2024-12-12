
<!-- QTY -->
<div class="form-group {{ $errors->has('qty') ? ' has-error' : '' }}">
    <label for="qty" class="col-md-3 control-label">{{ trans('general.quantity') }}</label>
    <div class="col-md-7">
       <div class="col-md-3" style="padding-left:0px">
           <input class="form-control" maxlength="5" type="text" name="qty" aria-label="qty" id="qty" value="{{ old('qty', $item->qty) }}" {!!  (Helper::checkIfRequired($item, 'qty')) ? ' required ' : '' !!}/>
       </div>
        <div class="col-md-12" style="padding-left:0px">
       {!! $errors->first('qty', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
   </div>
</div>
