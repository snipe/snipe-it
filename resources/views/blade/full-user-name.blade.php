@props([
    'user'
])

@if ($user)
    @if (! $user->trashed())
        {{-- if the user is in database but soft-deleted --}}
        <a href="{{ route('users.show', $user->id) }}">{{ $user->present()->fullName() }}</a>
    @else
        {{-- if the user exists --}}
        <s><a href="{{ route('users.show', $user->id) }}">{{ $user->present()->fullName() }}</a></s>
    @endif
@endif
