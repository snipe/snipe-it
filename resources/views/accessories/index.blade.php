@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.accessories') }}
@parent
@stop


{{-- Page content --}}
@section('content')
    <x-container>
        <x-box name="accessories" sr_only_title>
            <x-table.accessories name="accessories" :route="route('api.accessories.index')" fixed_right_number="3" />
        </x-box>
        <x-shiftclick/>
    </x-container>




    @can('update', \App\Models\Accessory::class)
    <x-modals.adjust-quantity />
@endcan
@stop


@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop
