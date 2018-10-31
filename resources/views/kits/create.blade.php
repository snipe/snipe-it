@extends('layouts/edit-form', [
    'createText' => 'Create kit',
    'updateText' => 'Update kit',
    'formAction' => ($item) ? route('kits.update', ['kit' => $item->id]) : route('kits.store'),
])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => 'Name']) {{--  TODO: trans  --}}
@stop