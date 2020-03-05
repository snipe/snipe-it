<!-- Purchase Cost -->
<div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
    <label for="price" class="col-md-3 control-label">{{ trans('general.price') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-3" style="padding-left: 0px;">
            <input class="form-control" type="text" name="price" id="price" value="{{ Input::old('price', \App\Helpers\Helper::formatCurrencyOutput($item->price)) }}" />
            <span class="input-group-addon">
                @if (isset($currency_type))
                    {{ $currency_type }}
                @else
                    {{ $snipeSettings->default_currency }}
                @endif
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('price', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
        </div>
    </div>

</div>
