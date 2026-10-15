@use('App\Helpers\Helper')

@props([
    'inputId' => 'fileUpload',
    'name' => 'file[]',
    'multiple' => true,
    'label' => trans('general.file_upload'),
])

@php
    // Errors bind to whichever shape the caller used. `file[]` reports on
    // file.* (per-file), a singular `file` reports on file itself.
    $errorKey = str_ends_with($name, '[]') ? rtrim($name, '[]').'.*' : $name;
    $selectLabel = $multiple ? trans('button.select_files') : trans('button.select_file');
@endphp

<x-form.row
    :label="$label"
    name="file"
    input_div_class="col-md-9"
    :id="$inputId.'-upload'"
    :errors_class="$errors->has($errorKey) ? ' has-error' : ''"
>
    <x-slot:input>
        <label class="btn btn-sm btn-theme" for="{{ $inputId }}">
            {{ $selectLabel }}
            <input
                type="file"
                name="{{ $name }}"
                @if ($multiple) multiple @endif
                class="js-uploadFile"
                id="{{ $inputId }}"
                data-maxsize="{{ Helper::file_upload_max_size() }}"
                accept="{{ config('filesystems.allowed_upload_mimetypes') }}"
                style="display:none"
                aria-label="file"
                aria-hidden="true"
            >
        </label>

        <span id="{{ $inputId }}-info"></span>
        <p class="help-block" id="{{ $inputId }}-status">
            {{ trans('general.upload_filetypes_help', ['allowed_filetypes' => config('filesystems.allowed_upload_extensions'), 'size' => Helper::file_upload_max_size_readable()]) }}
        </p>

        @foreach ($errors->get($errorKey) as $messages)
            @foreach ($messages as $message)
                <span class="alert-msg" role="alert" aria-live="assertive">{{ $message }}</span><br>
            @endforeach
        @endforeach
    </x-slot:input>
</x-form.row>
