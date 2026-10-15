@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/hardware/form.bulk_restore') }}
    @parent
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
    <x-container class="col-md-12">
        <p>{{ trans('admin/hardware/form.bulk_restore_help') }}</p>

        <x-form route="{{ route('hardware/bulkrestore') }}">
            <x-box>
                <x-slot:header>
                    <span style="color: red">
                        {{ trans('admin/hardware/form.bulk_restore_warn', ['asset_count' => count($assets)]) }}
                    </span>
                </x-slot:header>

                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <td></td>
                            <td>{{ trans('admin/hardware/table.id') }}</td>
                            <td>{{ trans('admin/hardware/form.name') }}</td>
                            <td>{{ trans('admin/hardware/table.location') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assets as $asset)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $asset->id }}" checked></td>
                                <td>{{ $asset->id }}</td>
                                <td>{{ $asset->display_name }}</td>
                                <td>
                                    @if ($asset->location)
                                        {{ $asset->location->name }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-slot:customfooter>
                    <div class="box-footer text-right">
                        <a class="btn btn-link pull-left" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
                        <button type="submit" class="btn btn-success" id="submit-button">
                            <x-icon type="checkmark" /> {{ trans('button.restore') }}
                        </button>
                    </div>
                </x-slot:customfooter>
            </x-box>
        </x-form>
    </x-container>
@stop
