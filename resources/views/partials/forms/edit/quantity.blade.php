
<!-- QTY -->
<div class="form-group {{ $errors->has('qty') ? ' has-error' : '' }}">
    <label for="qty" class="col-md-3 control-label">{{ trans('general.quantity') }}</label>
    <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'qty')) ? ' required' : '' }}">
       <div class="col-md-2" style="padding-left:0px">
           <input class="form-control" type="text" name="qty" id="qty" value="{{ Input::old('qty', $item->qty) }}" />
       </div>
       {!! $errors->first('qty', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
   </div>
</div>