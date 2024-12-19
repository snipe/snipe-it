@props([
    'route',
    'method' => 'POST',
    'files' => false,
])

<form
    action="{{ $route }}"
    method="POST"
    accept-charset="UTF-8"
    @if($files) enctype="multipart/form-data" @endif
    {{ $attributes }}
>
    @csrf
    @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
        <input type="hidden" name="_method" value="{{ strtoupper($method) }}">
    @endif
    {{ $slot }}
</form>
