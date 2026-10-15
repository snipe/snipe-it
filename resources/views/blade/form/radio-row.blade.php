{{-- input_div_class default depends on whether the row has a left-hand
     label. With a label, the row already spends col-md-3 on the left,
     without one the options need to be offset. Concentrating the grid
     class here means a future Bootstrap / AdminLTE upgrade only has to
     touch this file, not every place it's invoked. --}}
@props([
    'name' => null,
    'item' => null,
    'label' => null,
    'options' => [],
    'selected' => null,
    'required' => null,
    'disabled' => false,
    'help_text' => null,
    'help_icon' => null,
    'info_tooltip_text' => null,
    'input_div_class' => isset($label) ? 'col-md-8' : 'col-md-8 col-md-offset-3',
])

@php
    // Redisplay-safe current value. On validation-failure redisplay
    // session()->hasOldInput() is true and we trust old($name); on fresh
    // render we take the caller's :selected value, or fall back to the
    // model attribute. This is the same guard as checkbox-row: an old-input
    // value of null on redisplay means "nothing selected", not "fall back
    // to the stale model default".
    $is_redisplay = session()->hasOldInput();
    if ($is_redisplay) {
        $current_value = old($name);
    } else {
        $current_value = $selected ?? $item?->{$name};
    }

    // Helper::checkIfRequired dereferences $item statically via $item::rules(),
    // so it needs a real class/object. Fall back to false when no model was
    // supplied (transient forms like bulk checkin have no persistent model).
    $really_required = $required ?? ($item ? Helper::checkIfRequired($item, $name) : false);
    $errors_class = $errors->has($name) ? ' has-error' : '';
@endphp

<div {{ $attributes->merge(['class' => 'form-group'.$errors_class]) }}>

    @if (isset($label))
        <x-form.label :for="$name" class="col-md-3">{{ $label }}</x-form.label>
    @endif

    <div class="{{ $input_div_class }}">
        @foreach ($options as $option_value => $option_label)
            <label class="form-control">
                <x-input.radio
                    :name="$name"
                    :value="$option_value"
                    :checked="$current_value !== null && (string) $current_value === (string) $option_value"
                    :required="$really_required && $loop->first"
                    :disabled="$disabled"
                    :aria-label="$name"
                    :aria-describedby="$help_text ? $name.'-help' : null"
                />
                {{ $option_label }}
            </label>
        @endforeach
    </div>

    @if ($info_tooltip_text)
        <div class="col-md-1 text-left" style="padding-left:0; margin-top: 5px;">
            <x-form.tooltip>
                {{ $info_tooltip_text }}
            </x-form.tooltip>
        </div>
    @endif

    @if ($errors->has($name))
        <div class="col-md-8 col-md-offset-3">
            <x-form.error :name="$name" />
        </div>
    @endif

    @if ($help_text)
        <div class="col-md-8 col-md-offset-3">
            <x-form.help :name="$name" :icon="$help_icon">{!! $help_text !!}</x-form.help>
        </div>
    @endif

</div>
