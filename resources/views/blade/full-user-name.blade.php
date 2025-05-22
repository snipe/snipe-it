@props([
    'user'
])

@if($user)
    @can('view', $user)
        @if(! $user->trashed())
            {{-- if the user is in database but soft-deleted --}}
            <a href="{{ route('users.show', $user->id) }}">{{ $user->present()->fullName() }}</a>
        @else
            {{-- if the user exists --}}
            <s><a href="{{ route('users.show', $user->id) }}">{{ $user->present()->fullName() }}</a></s>
        @endif
    @else
        @if(! $user->trashed())
            {{-- if the user is in database but soft-deleted --}}
            <span>{{ $user->present()->fullName() }}</span>
        @else
            {{-- if the user exists --}}
            <s><span>{{ $user->present()->fullName() }}</span></s>
        @endif
    @endcan
@endif
