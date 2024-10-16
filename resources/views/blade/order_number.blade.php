@props(['value' => '','name' => 'order_id','div_class' => ''])
<div class="form-group {{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="order_number" class="col-md-3 control-label">{{ trans('general.order_number') }}</label>
    <div class="{{ $div_class }}">
        <select name="{{ $name }}"
                {{ $attributes->merge(['class' => 'select2 order-select']) }} aria-label="{{ $name }}"
                id="{{ $name }}"
                data-allow-clear="true" data-placeholder="{{ trans('general.select_order') }}" data-tags="true"
                data-create-new="{{ trans('general.select_create_new_order') }}"
                style="width:100%">
            <option>{{-- Required to make an 'unselectable' first thing --}}</option>
            @foreach(App\Models\Order::orderBy('order_number')->get() as $order)
                <option value="{{ $order->id }}"
                        {{ $order->id == $value ? " selected='selected'": "" }} role="option">{{ $order->order_number }}</option>
            @endforeach
        </select>
        <input type="hidden" name="{{ $name }}_new_order" id="{{ $name }}_new_order" value=""/>
        {!! $errors->first($name, '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
{{-- Alison wants to add 'data-tags="true"' to inline-create an order... --}}
{{--
   <div class="col-md-7 col-sm-12">
       <input class="form-control" type="text" name="order_number" aria-label="order_number" id="order_number" value="{{ old('order_number', $item->order_number) }}" />
       {!! $errors->first('order_number', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
   </div>



--}}