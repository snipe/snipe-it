@props([
    'route',
    'method' => 'POST',
    'files' => false,
])

<form
    action="{{ $route }}"
    method="{{ $method }}"
    accept-charset="UTF-8"
    @if($files) enctype="multipart/form-data" @endif
    {{ $attributes }}
>
    {{ $slot }}
</form>
