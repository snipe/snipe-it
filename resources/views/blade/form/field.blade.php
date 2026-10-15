{{-- Pure field-dispatch component. Renders the widget only (no label,
     no form-group, no help / error scaffold). Use directly when you need
     the widget without x-form.row's layout, or let x-form.row call it
     for you when you want the full field row. --}}
@props([
    'name' => null,
    'type' => 'text',
    'item' => null,
    'id' => null,
    'required' => null,
    'default' => null,
    'input_icon' => null,
    'input_group_addon' => null,
    'maxlength' => null,
    'min' => null,
    'max' => null,
    'rows' => null,
    'placeholder' => null,
    'help_text' => null,
    'end_date' => null,
    'default_now' => true,
    'side_by_side' => false,
])

@php
    $input_id = $id ?? $name;
    $is_required = $required ?? Helper::checkIfRequired($item, $name);

    $blade_type = in_array($type, ['text', 'email', 'url', 'tel', 'number', 'password']) ? 'text' : $type;

    // Maxlength precedence:
    //   1. Explicit :maxlength="..." from the caller (always wins).
    //   2. Model rules. Helper::fieldMaxLength reads `max:N` from the
    //      model's validation rules so the browser cap matches the DB
    //      column width automatically. Applied to all types except
    //      textarea and number (textareas back TEXT columns with no
    //      length limit, browsers ignore maxlength on type="number").
    //   3. Fallback 191 for text-family types (matches the vast majority
    //      of varchar(191) columns in this schema).
    $effective_maxlength = $maxlength
        ?? ($type !== 'textarea' && $type !== 'number' ? Helper::fieldMaxLength($item, $name) : null)
        ?? (in_array($type, ['text', 'email', 'url', 'tel', 'password']) ? 191 : null);
@endphp

@isset($input)
    {{ $input }}
@elseif ($blade_type === 'colorpicker')
    <x-input.colorpicker
        :name="$name"
        :id="$input_id"
        :item="$item"
        :default="$default"
    />
@elseif ($blade_type === 'datepicker')
    {{-- $item->{$name} may be a Carbon (models that cast the column to
         `date`, e.g. License::purchase_date) or a plain string. Normalize
         to Y-m-d via strtotime so the datepicker JS can parse it. Without
         this, Carbon stringifies as "Y-m-d H:i:s", the picker fails to
         parse it, renders blank, and submit wipes the field. --}}
    <x-input.datepicker
        :name="$name"
        :id="$input_id"
        :value="old($name, $item?->{$name} ? date('Y-m-d', strtotime((string) $item->{$name})) : $default)"
        :required="$is_required"
        :placeholder="$placeholder"
        :end_date="$end_date"
    />
@elseif ($blade_type === 'datetimepicker')
    <x-input.datetimepicker
        :name="$name"
        :id="$input_id"
        :value="old($name, $item?->{$name}?->format('Y-m-d H:i:s') ?? $item?->{$name} ?? $default)"
        :required="$is_required"
        :placeholder="$placeholder"
        :default_now="$default_now"
        :side_by_side="$side_by_side"
    />
@else
    <x-dynamic-component
        :$name
        :$type
        :aria-label="$name"
        :aria-describedby="$help_text ? $input_id.'-help' : null"
        :component="'input.'.$blade_type"
        :id="$input_id"
        :required="$is_required"
        :value="old($name, $item?->{$name})"
        :input_icon="$input_icon"
        :input_group_addon="$input_group_addon"
        :maxlength="$effective_maxlength"
        :min="$min"
        :max="$max"
        :rows="$rows"
        :placeholder="$placeholder"
    />
@endisset
