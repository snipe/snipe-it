@extends('users.print-shell')

@section('content')

    @foreach($users as $show_user)
        <h3>
            {{ trans('general.assigned_to', ['name' => $show_user->present()->fullName()]) }}
            {{ ($show_user->employee_num!='') ? ' (#'.$show_user->employee_num.') ' : '' }}
            {{ ($show_user->jobtitle!='' ? ' - '.$show_user->jobtitle : '') }}
        </h3>
        <p></p>{{ trans('admin/users/general.all_assigned_list_generation')}} {{ Helper::getFormattedDateObject(now(), 'datetime', false) }}

        @if ($show_user->assets->count() > 0)
            @php
                $counter = 1;
            @endphp

            <div id="assets-toolbar">
                <h4>{{ trans_choice('general.countable.assets', $show_user->assets->count(), ['count' => $show_user->assets->count()]) }}
                </h4>
            </div>

            <table
                class="snipe-table table table-striped inventory"
                id="AssetsAssigned"
                data-pagination="false"
                data-id-table="AssetsAssigned"
                data-search="false"
                data-side-pagination="client"
                data-sortable="true"
                data-toolbar="#assets-toolbar"
                data-show-columns="true"
                data-sort-order="desc"
                data-sort-name="created_at"
                data-show-columns-toggle-all="true"
                data-cookie-id-table="AssetsAssigned">
                <thead>
                <th data-field="asset_id" data-sortable="false" data-visible="true" data-switchable="false">#</th>
                <th data-field="asset_image" data-sortable="true" data-visible="false" data-switchable="true">{{ trans('general.image') }}</th>
                <th data-field="asset_tag" data-sortable="true" data-visible="true" data-switchable="false">{{ trans('admin/hardware/table.asset_tag') }}</th>
                <th data-field="asset_name" data-sortable="true" data-visible="true">{{ trans('general.name') }}</th>
                <th data-field="asset_category" data-sortable="true" data-visible="true">{{ trans('general.category') }}</th>
                <th data-field="asset_model" data-sortable="true" data-visible="true">{{ trans('admin/hardware/form.model') }}</th>
                <th data-field="rtd_location" data-sortable="true" data-visible="true">{{ trans('admin/hardware/form.default_location') }}</th>
                <th data-field="asset_location" data-sortable="true" data-visible="false">{{ trans('general.location') }}</th>
                <th data-field="asset_serial" data-sortable="true" data-visible="true">{{ trans('admin/hardware/form.serial') }}</th>
                <th data-field="asset_checkout_date" data-sortable="true" data-visible="true">{{ trans('admin/hardware/table.checkout_date') }}</th>
                <th data-field="signature" data-sortable="true" data-visible="true">{{ trans('general.signature') }}</th>
                </thead>
                <tbody>
                @foreach ($show_user->assets as $asset)
                    @php
                        if ($asset->model->category->getEula()) $eulas[] = $asset->model->category->getEula()
                    @endphp
                    <tr>
                        <td>{{ $counter }}</td>
                        <td>
                            @if ($asset->getImageUrl())
                                <img src="{{ $asset->getImageUrl() }}" class="thumbnail" style="max-height: 50px;">
                            @endif
                        </td>
                        <td>{{ $asset->asset_tag }}</td>
                        <td>{{ $asset->name }}</td>
                        <td>{{ (($asset->model) && ($asset->model->category)) ? $asset->model->category->name : trans('general.invalid_category') }}</td>
                        <td>{{ ($asset->model) ? $asset->model->name : trans('general.invalid_model') }}</td>
                        <td>{{ ($asset->defaultLoc) ? $asset->defaultLoc->name : '' }}</td>
                        <td>{{ ($asset->location) ? $asset->location->name : '' }}</td>
                        <td>{{ $asset->serial }}</td>
                        <td>
                            {{ Helper::getFormattedDateObject($asset->last_checkout, 'datetime', false) }}</td>
                        <td>
                            @if (($asset->assetlog->first()) && ($asset->assetlog->first()->accept_signature!=''))
                                <img style="width:auto;height:100px;" src="{{ asset('/') }}display-sig/{{ $asset->assetlog->first()->accept_signature }}">
                            @endif
                        </td>
                    </tr>
                    @if ($settings->show_assigned_assets)
                        @php
                            $assignedCounter = 1;
                        @endphp
                        @foreach ($asset->assignedAssets as $asset)
                            <tr>
                                <td>{{ $counter }}.{{ $assignedCounter }}</td>
                                <td>
                                    @if ($asset->getImageUrl())
                                        <img src="{{ $asset->getImageUrl() }}" class="thumbnail" style="max-height: 50px;">
                                    @endif
                                </td>
                                <td>{{ $asset->asset_tag }}</td>
                                <td>{{ $asset->name }}</td>
                                <td>{{ (($asset->model) && ($asset->model->category)) ? $asset->model->category->name : trans('general.invalid_category') }}</td>
                                <td>{{ ($asset->model) ? $asset->model->name : trans('general.invalid_model') }}</td>
                                <td>{{ ($asset->defaultLoc) ? $asset->defaultLoc->name : '' }}</td>
                                <td>{{ ($asset->location) ? $asset->location->name : '' }}</td>
                                <td>{{ $asset->serial }}</td>
                                <td>
                                    {{ Helper::getFormattedDateObject($asset->last_checkout, 'datetime', false) }}</td>
                                <td>
                                    @if (($asset->assetlog->first()) && ($asset->assetlog->first()->accept_signature!=''))
                                        <img style="width:auto;height:100px;" src="{{ asset('/') }}display-sig/{{ $asset->assetlog->first()->accept_signature }}">
                                    @endif
                                </td>
                            </tr>
                            @php
                                $assignedCounter++
                            @endphp
                        @endforeach
                    @endif
                    @php
                        $counter++
                    @endphp
                @endforeach
                </tbody>
            </table>
        @endif

        @if ($show_user->licenses->count() > 0)
            <div id="licenses-toolbar">
                <h4>{{ trans_choice('general.countable.licenses', $show_user->licenses->count(), ['count' => $show_user->licenses->count()]) }}</h4>
            </div>

            <table
                class="snipe-table table table-striped inventory"
                id="licensessAssigned"
                data-toolbar="#licenses-toolbar"
                data-pagination="false"
                data-id-table="licensessAssigned"
                data-search="false"
                data-side-pagination="client"
                data-sortable="true"
                data-show-columns="true"
                data-sort-order="desc"
                data-sort-name="created_at"
                data-show-columns-toggle-all="true"
                data-cookie-id-table="licensessAssigned">
                <thead>
                <tr>
                    <th style="width: 20px;" data-sortable="false" data-switchable="false">#</th>
                    <th style="width: 40%;" data-sortable="true" data-switchable="false">{{ trans('general.name') }}</th>
                    <th style="width: 50%;" data-sortable="true">{{ trans('admin/licenses/form.license_key') }}</th>
                    <th style="width: 10%;" data-sortable="true">{{ trans('admin/hardware/table.checkout_date') }}</th>
                </tr>
                </thead>
                @php
                    $lcounter = 1;
                @endphp

                @foreach ($show_user->licenses as $license)
                    @php
                        if ($license->category->getEula()) $eulas[] = $license->category->getEula()
                    @endphp
                    <tr>
                        <td>{{ $lcounter }}</td>
                        <td>{{ $license->name }}</td>
                        <td>
                            @can('viewKeys', $license)
                                {{ $license->serial }}
                            @else
                                <i class="fa-lock" aria-hidden="true"></i> {{ str_repeat('x', 15) }}
                            @endcan
                        </td>
                        <td>{{  $license->pivot->updated_at }}</td>
                    </tr>
                    @php
                        $lcounter++
                    @endphp
                @endforeach
            </table>
        @endif


        @if ($show_user->accessories->count() > 0)
            <div id="accessories-toolbar">
                <h4>{{ trans_choice('general.countable.accessories', $show_user->accessories->count(), ['count' => $show_user->accessories->count()]) }}</h4>
            </div>

            <table
                class="snipe-table table table-striped inventory"
                id="accessoriesAssigned"
                data-toolbar="#accessories-toolbar"
                data-pagination="false"
                data-id-table="accessoriesAssigned"
                data-search="false"
                data-side-pagination="client"
                data-sortable="true"
                data-show-columns="true"
                data-sort-order="desc"
                data-sort-name="created_at"
                data-show-columns-toggle-all="true"
                data-cookie-id-table="accessoriesAssigned">
                <thead>
                <tr>
                    <th style="width: 20px;" data-sortable="false" data-switchable="false">#</th>
                    <th data-field="accessory_image" data-sortable="true"  data-visible="true">{{ trans('general.image') }}</th>
                    <th style="width: 40%;" data-sortable="true" data-switchable="false">{{ trans('general.name') }}</th>
                    <th style="width: 50%;" data-sortable="true">{{ trans('general.category') }}</th>
                    <th style="width: 10%;" data-sortable="true">{{ trans('admin/hardware/table.checkout_date') }}</th>
                    <th style="width: 10%;" data-sortable="true">{{ trans('general.signature') }}</th>
                </tr>
                </thead>
                @php
                    $acounter = 1;
                @endphp

                @foreach ($show_user->accessories as $accessory)
                    @if ($accessory)
                        @php
                            if ($accessory->category->getEula()) $eulas[] = $accessory->category->getEula()
                        @endphp
                        <tr>
                            <td>{{ $acounter }}</td>
                            <td>
                                @if ($accessory->getImageUrl())
                                    <img src="{{ $accessory->getImageUrl() }}" class="thumbnail" style="max-height: 50px;">
                                @endif
                            </td>
                            <td>{{ ($accessory->manufacturer) ? $accessory->manufacturer->name : '' }} {{ $accessory->name }} {{ $accessory->model_number }}</td>
                            <td>{{ $accessory->category->name }}</td>
                            <td>{{ $accessory->pivot->created_at }}</td>

                            <td>
                                @if (($accessory->assetlog->first()) && ($accessory->assetlog->first()->accept_signature!=''))
                                    <img style="width:auto;height:100px;" src="{{ asset('/') }}display-sig/{{ $accessory->assetlog->first()->accept_signature }}">
                                @endif
                            </td>
                        </tr>
                        @php
                            $acounter++
                        @endphp
                    @endif
                @endforeach
            </table>
        @endif

        @if ($show_user->consumables->count() > 0)
            <div id="consumables-toolbar">
                <h4>{{ trans_choice('general.countable.consumables', $show_user->consumables->count(), ['count' => $show_user->consumables->count()]) }}</h4>
            </div>

            <table
                class="snipe-table table table-striped inventory"
                id="consumablesAssigned"
                data-pagination="false"
                data-toolbar="#consumables-toolbar"
                data-id-table="consumablesAssigned"
                data-search="false"
                data-side-pagination="client"
                data-sortable="true"
                data-show-columns="true"
                data-sort-order="desc"
                data-sort-name="created_at"
                data-show-columns-toggle-all="true"
                data-cookie-id-table="consumablesAssigned">
                <thead>
                <tr>
                    <th style="width: 20px;" data-sortable="false" data-switchable="false"></th>
                    <th style="width: 40%;" data-sortable="true" data-switchable="false">{{ trans('general.name') }}</th>
                    <th style="width: 50%;" data-sortable="true">{{ trans('general.category') }}</th>
                    <th style="width: 10%;" data-sortable="true">{{ trans('admin/hardware/table.checkout_date') }}</th>
                    <th style="width: 10%;" data-sortable="true">{{ trans('general.signature') }}</th>

                </tr>
                </thead>
                @php
                    $ccounter = 1;
                @endphp

                @foreach ($show_user->consumables as $consumable)
                    @if ($consumable)
                        @php
                            if ($consumable->category->getEula()) $eulas[] = $consumable->category->getEula()
                        @endphp
                        <tr>
                            <td>{{ $ccounter }}</td>
                            <td>
                            @if ($consumable->deleted_at!='')
                                <td>{{ ($consumable->manufacturer) ? $consumable->manufacturer->name : '' }}  {{ $consumable->name }} {{ $consumable->model_number }}</td>
                                @else
                                    {{ ($consumable->manufacturer) ? $consumable->manufacturer->name : '' }}  {{ $consumable->name }} {{ $consumable->model_number }}
                                @endif
                                </td>
                                <td>{{ ($consumable->category) ? $consumable->category->name : ' invalid/deleted category' }} </td>
                                <td>{{  $consumable->pivot->created_at }}</td>
                                <td>
                                    @if (($consumable->assetlog->first()) && ($consumable->assetlog->first()->accept_signature!=''))
                                        <img style="width:auto;height:100px;" src="{{ asset('/') }}display-sig/{{ $consumable->assetlog->first()->accept_signature }}">
                                    @endif
                                </td>
                        </tr>
                        @php
                            $ccounter++
                        @endphp
                    @endif
                @endforeach
            </table>
        @endif

        <p></p>
        <div class="pull-right">
            <button class="btn btn-default hidden-print" type="button" data-toggle="collapse" data-target="#eula-row" aria-expanded="false" aria-controls="eula-row" title="EULAs">
                <i class="fa fa-eye-slash"></i>
            </button>
        </div>

        <table style="margin-top: 80px;" class="snipe-table">
            <tr class="collapse" id="eula-row">
                <td style="padding-right: 10px; vertical-align: top; font-weight: bold;">EULA</td>
                <td style="padding-right: 10px; vertical-align: top; padding-bottom: 80px;" colspan="3">
                    @php
                        if (!empty($eulas)) $eulas = array_unique($eulas);
                    @endphp
                    @if (!empty($eulas))
                        @foreach ($eulas as $key => $eula)
                            {!! $eula !!}
                        @endforeach
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding-right: 10px; vertical-align: top; font-weight: bold;">{{ trans('general.signed_off_by') }}:</td>
                <td style="padding-right: 10px; vertical-align: top;">______________________________________</td>
                <td style="padding-right: 10px; vertical-align: top;">______________________________________</td>
                <td>_____________</td>
            </tr>
            <tr style="height: 80px;">
                <td></td>
                <td style="padding-right: 10px; vertical-align: top;">{{ trans('general.name') }}</td>
                <td style="padding-right: 10px; vertical-align: top;">{{ trans('general.signature') }}</td>
                <td style="padding-right: 10px; vertical-align: top;">{{ trans('general.date') }}</td>
            </tr>
            <tr>
                <td style="padding-right: 10px; vertical-align: top; font-weight: bold;">{{ trans('admin/users/table.manager') }}:</td>
                <td style="padding-right: 10px; vertical-align: top;">______________________________________</td>
                <td style="padding-right: 10px; vertical-align: top;">______________________________________</td>
                <td>_____________</td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-right: 10px; vertical-align: top;">{{ trans('general.name') }}</td>
                <td style="padding-right: 10px; vertical-align: top;">{{ trans('general.signature') }}</td>
                <td style="padding-right: 10px; vertical-align: top;">{{ trans('general.date') }}</td>
                <td></td>
            </tr>

        </table>
    @endforeach

@endsection
