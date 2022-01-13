@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.import') }}
@parent
@stop

{{-- Page content --}}
@section('content')
    {{-- Hide importer until vue has rendered it, if we continue using vue for other things we should move this higher in the style --}}
    {{-- <style>
        [v-cloak] {
            display:none;
        }

THIS IS VUE STUFF ISNT IT?
    </style> --}}
@livewire('importer') {{-- Yes, this is stupid - we should be able to route straight over and not have this, but Livewire doesn't work in this app that way :/ --}}
@stop

@section('moar_scripts')
{{-- <script nonce="{{ csrf_token() }}">
    new Vue({
        el: '#app'
    });
</script> --}}
@endsection
