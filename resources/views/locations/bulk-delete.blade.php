@extends('layouts/default')

@section('title')
    {{ trans('general.bulk.delete.header', ['object_type' => trans_choice('general.location_plural', $valid_count)]) }}
    @parent
@stop

@section('content')
    <x-container class="col-md-8 col-md-offset-2">
        <x-callout type="warning" icon="warning" live="assertive">
            @if ($valid_count < $selected_count)
                {{ trans('general.bulk.delete.warn_partial', [
                    'selected_count' => $selected_count,
                    'valid_count' => $valid_count,
                    'object_type' => trans_choice('general.location_plural', $selected_count),
                ]) }}
            @else
                {{ trans_choice('general.bulk.delete.warn', $valid_count, [
                    'count' => $valid_count,
                    'object_type' => trans_choice('general.location_plural', $valid_count),
                ]) }}
            @endif
        </x-callout>

        <x-form route="{{ route('locations.bulkdelete.store') }}">
            <x-box>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">
                                <label class="sr-only" for="checkAll">{{ trans('general.select_all') }}</label>
                                <input type="checkbox" id="checkAll" checked data-toggle="check-all">
                            </th>
                            <th scope="col">{{ trans('general.name') }}</th>
                            <th scope="col" class="text-right" data-tooltip="true" data-title="{{ trans('general.users') }}">
                                <i class="fas fa-users fa-fw fa-lg"></i>
                            </th>
                            <th scope="col" class="text-right" data-tooltip="true" data-title="{{ trans('admin/locations/message.current_location') }}">
                                <i class="fas fa-barcode fa-fw fa-lg"></i>
                            </th>
                            <th scope="col" class="text-right" data-tooltip="true" data-title="{{ trans('admin/hardware/form.default_location') }}">
                                <i class="fa-solid fa-house-flag fa-fw fa-lg"></i>
                            </th>
                            <th scope="col" class="text-right" data-tooltip="true" data-title="{{ trans('admin/locations/message.assigned_assets') }}">
                                <i class="fas fa-barcode fa-fw fa-lg"></i>
                            </th>
                            <th scope="col" class="text-right" data-tooltip="true" data-title="{{ trans('general.accessories') }}">
                                <i class="far fa-keyboard fa-fw fa-lg"></i>
                            </th>
                            <th scope="col" class="text-right" data-tooltip="true" data-title="{{ trans('general.accessories_assigned') }}">
                                <i class="fas fa-keyboard fa-fw fa-lg"></i>
                            </th>
                            <th scope="col" class="text-right" data-tooltip="true" data-title="{{ trans('general.consumables') }}">
                                <i class="fas fa-tint fa-fw fa-lg"></i>
                            </th>
                            <th scope="col" class="text-right" data-tooltip="true" data-title="{{ trans('general.components') }}">
                                <i class="far fa-hdd fa-fw fa-lg"></i>
                            </th>
                            <th scope="col" class="text-right" data-tooltip="true" data-title="{{ trans('general.child_locations') }}">
                                <i class="fa-solid fa-city fa-fw fa-lg"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locations as $location)
                            @php $isDeletable = $location->isDeletable(); @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $location->id }}"
                                        @if ($isDeletable) checked @else disabled @endif>
                                </td>
                                <td @class(['text-muted' => ! $isDeletable])>
                                    @if ($location->tag_color)
                                        <x-icon type="square" class="fa-fw" style="color: {{ $location->tag_color }};"/>
                                    @endif
                                    {{ $location->name }}
                                </td>
                                <td class="text-right {{ $location->users_count > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format((int) $location->users_count) }}</td>
                                <td class="text-right {{ $location->assets_count > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format((int) $location->assets_count) }}</td>
                                <td class="text-right {{ $location->rtd_assets_count > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format((int) $location->rtd_assets_count) }}</td>
                                <td class="text-right {{ $location->assigned_assets_count > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format((int) $location->assigned_assets_count) }}</td>
                                <td class="text-right {{ $location->accessories_count > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format((int) $location->accessories_count) }}</td>
                                <td class="text-right {{ $location->assigned_accessories_count > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format((int) $location->assigned_accessories_count) }}</td>
                                <td class="text-right {{ $location->consumables_count > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format((int) $location->consumables_count) }}</td>
                                <td class="text-right {{ $location->components_count > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format((int) $location->components_count) }}</td>
                                <td class="text-right {{ $location->children_count > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format((int) $location->children_count) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-slot:customfooter>
                    <div class="box-footer text-right">
                        <a class="btn btn-link pull-left" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
                        <button type="submit" class="btn btn-success" id="submit-button">
                            <x-icon type="checkmark" /> {{ trans('general.delete') }}
                        </button>
                    </div>
                </x-slot:customfooter>
            </x-box>
        </x-form>
    </x-container>
@stop
