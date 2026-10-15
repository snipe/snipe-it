{{--
    Bridge layout for full-page Livewire components. layouts/default uses
    @section('content') and @section('title'), but Livewire's `->layout()`
    renders into $slot — this adapter wires them together so a full-page
    Livewire component can set title / helpText via layoutData(...) and
    have its render output land in the right place.
--}}
@extends('layouts/default', [
    'helpText' => $helpText ?? null,
    'helpPosition' => $helpPosition ?? 'left',
])

@section('title')
    {{ $title ?? '' }}
    @parent
@stop

@section('content')
    {{ $slot }}
@stop
