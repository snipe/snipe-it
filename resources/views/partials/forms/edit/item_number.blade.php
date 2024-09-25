<!-- Item Number -->
<div class="form-group {{ $errors->has('item_no') ? ' has-error' : '' }}">
   <label for="item_no" class="col-md-3 control-label">{{ trans('admin/consumables/general.item_no') }}</label>
   <div class="col-md-7 col-sm-12{{  (Helper::checkIfRequired($item, 'item_no')) ? ' required' : '' }}">
       <input class="form-control" type="text" name="item_no" id="item_no" value="{{ old('item_no', $item->item_no) }}" />
       <x-form-error name="item_no" />
   </div>
</div>
