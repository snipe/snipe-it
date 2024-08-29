<!-- Order Number -->
<div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
   <label for="order_number" class="col-md-3 control-label">{{ trans('general.order_number') }}</label>
   <div class="col-md-7 col-sm-12">
       <input class="form-control" type="text" name="order_number" aria-label="order_number" id="order_number" value="{{ old('order_number', $item->order_number) }}" />
       <x-form-error name="order_number" />
   </div>
</div>
