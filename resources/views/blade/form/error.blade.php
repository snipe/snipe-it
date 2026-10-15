@props(['name'])
@error($name)
    <span class="alert-msg" role="alert" aria-live="assertive">{{ $message }}</span>
@enderror
