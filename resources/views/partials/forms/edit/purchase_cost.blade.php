<!-- Purchase Cost -->
<div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
   <label for="purchase_cost" class="col-md-3 control-label">{{ trans('general.purchase_cost') }} </label>
   <div class="col-md-2">
       <div class="input-group">
           <span class="input-group-addon">
                @if (isset($currency_type))
                {{ $currency_type }}
                @else
               {{ $snipeSettings->default_currency }}
               @endif
           </span>
           <input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', \App\Helpers\Helper::formatCurrencyOutput($item->purchase_cost)) }}" />
           {!! $errors->first('purchase_cost', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
       </div>
   </div>
</div>
