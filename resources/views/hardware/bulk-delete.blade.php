@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.bulk_delete') }}
    @parent
@stop

{{-- Page content --}}
@section('content')
    <x-container class="col-md-8 col-md-offset-2">
        <p>{{ trans('admin/hardware/form.bulk_delete_help') }}</p>

        <x-form route="{{ route('hardware.bulkdelete.store') }}">
            <x-box>
                <x-callout type="warning" icon="warning" live="assertive">
                    {{ trans('admin/hardware/form.bulk_delete_warn', ['asset_count' => count($assets)]) }}
                </x-callout>

                <table class="table table-striped">
                    <tr>
                        <th></th>
                        <th>{{ trans('admin/hardware/table.id') }}</th>
                        <th>{{ trans('general.asset_name') }}</th>
                        <th>{{ trans('admin/hardware/table.location') }}</th>
                        <th>{{ trans('admin/hardware/table.assigned_to') }}</th>
                    </tr>

                    <tbody>
                        @foreach ($assets as $asset)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $asset->id }}" checked></td>
                                <td>{{ $asset->id }}</td>
                                <td>{{ $asset->display_name }}</td>
                                <td>
                                    @if ($asset->location)
                                        {{ $asset->location->display_name }}
                                    @elseif ($asset->rtd_location)
                                        {{ $asset->defaultLoc->display_name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($asset->assigned)
                                        {{ $asset->assigned->display_name }}
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
                            <x-icon type="checkmark" /> {{ trans('button.delete') }}
                        </button>
                    </div>
                </x-slot:customfooter>
            </x-box>
        </x-form>
    </x-container>
@stop
