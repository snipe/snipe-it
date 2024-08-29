@props(['name'])
@error($name)
    <span class="alert-msg">
        <x-icon type="x"/> {{ $message }}
    </span>
@enderror