<!-- Purchase Cost -->
<div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
    <label for="purchase_cost" class="col-md-3 control-label">{{ trans('general.purchase_cost') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-9" style="padding-left: 0px;">
            <div class="col-sm-8" style="padding-left: 0px;">         
                <input class="form-control" type="text" name="purchase_cost" aria-label="purchase_cost" id="purchase_cost" value="{{ old('purchase_cost', Helper::formatCurrencyOutput($item->purchase_cost)) }}" />
            </div>    
            <!-- <span class="input-group-addon">
                @if (isset($currency_type))
                    {{ $currency_type }}
                @else
                    {{ $snipeSettings->default_currency }}
                @endif
            </span> -->
            <div class="col-sm-4" style="padding-left: 0px;">
                <select class="form-control" name="money">
                    @if (isset($currency_type))
                    <option {{ $item->money == $currency_type ? 'selected':''}}>
                            {{ $currency_type }}
                    @else
                    <option>
                            ARG
                     @endif
                    </option>
                    <option {{ $item->money == 'USD' ? 'selected':''}}>
                            USD 
                    </option>                   
                </select>
            </div>    
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('purchase_cost', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>

</div>
