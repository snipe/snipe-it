@extends('layouts/default')

{{-- Page title --}}
@section('title')

    {{ $component->name }}
    {{ trans('general.component') }}
    @parent
@stop

{{-- Right header --}}
@section('header_right')
    @can('manage', $component)
        <div class="dropdown pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                {{ trans('button.actions') }}
                <span class="caret"></span>
            </button>

            <ul class="dropdown-menu pull-right" role="menu22">
                @if ($component->assigned_to != '')
                    @can('checkin', $component)
                        <li role="menuitem">
                            <a href="{{ route('components.checkin.show', $component->id) }}">
                                {{ trans('admin/components/general.checkin') }}
                            </a>
                        </li>
                    @endcan
                @else
                    @can('checkout', $component)
                        <li role="menuitem">
                            <a href="{{ route('components.checkout.show', $component->id)  }}">
                                {{ trans('admin/components/general.checkout') }}
                            </a>
                        </li>
                    @endcan
                @endif

                @can('update', $component)
                    <li role="menuitem">
                        <a href="{{ route('components.edit', $component->id) }}">
                            {{ trans('admin/components/general.edit') }}
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    @endcan
@stop


{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table table-responsive">

                                <table
                                        data-cookie-id-table="componentsCheckedoutTable"
                                        data-pagination="true"
                                        data-id-table="componentsCheckedoutTable"
                                        data-search="true"
                                        data-side-pagination="server"
                                        data-show-columns="true"
                                        data-show-export="true"
                                        data-show-footer="true"
                                        data-show-refresh="true"
                                        data-sort-order="asc"
                                        data-sort-name="name"
                                        id="componentsCheckedoutTable"
                                        class="table table-striped snipe-table"
                                        data-url="{{ route('api.components.assets', $component->id)}}"
                                        data-export-options='{
                "fileName": "export-components-{{ str_slug($component->name) }}-checkedout-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                                    <thead>
                                    <tr>
                                        <th data-searchable="false" data-sortable="false" data-field="name"
                                            data-formatter="hardwareLinkFormatter">
                                            {{ trans('general.asset') }}
                                        </th>
                                        <th data-searchable="false" data-sortable="false" data-field="qty">
                                            {{ trans('general.qty') }}
                                        </th>
                                        <th data-searchable="false" data-sortable="false" data-field="note">
                                            {{ trans('general.notes') }}
                                        </th>
                                        <th data-searchable="false" data-sortable="false" data-field="created_at"
                                            data-formatter="dateDisplayFormatter">
                                            {{ trans('general.date') }}
                                        </th>
                                        <th data-switchable="false" data-searchable="false" data-sortable="false"
                                            data-field="checkincheckout" data-formatter="componentsInOutFormatter">
                                            {{ trans('general.checkin') }}/{{ trans('general.checkout') }}
                                        </th>
                                    </tr>
                                    </thead>
                                </table>

                            </div>
                        </div> <!-- .col-md-12-->
                    </div>
                </div>
            </div>
        </div> <!-- .col-md-9-->


        <!-- side address column -->
        <div class="col-md-3">
            @if ($component->image!='')
                <div class="col-md-12 text-center" style="padding-bottom: 15px;">
                    <a href="{{ Storage::disk('public')->url('components/'.e($component->image)) }}"
                       data-toggle="lightbox">
                        <img src="{{ Storage::disk('public')->url('components/'.e($component->image)) }}"
                             class="img-responsive img-thumbnail" alt="{{ $component->name }}"></a>
                </div>

            @endif

            @if ($component->serial!='')
                <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/hardware/form.serial') }}
                        : </strong>
                    {{ $component->serial }} </div>
            @endif

            @if ($component->purchase_date)
                <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/components/general.date') }}
                        : </strong>
                    {{ $component->purchase_date }} </div>
            @endif

            @if ($component->purchase_cost)
                <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/components/general.cost') }}
                        :</strong>
                    {{ $snipeSettings->default_currency }}

                    {{ Helper::formatCurrencyOutput($component->purchase_cost) }} </div>
            @endif

            @if ($component->order_number)
                <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('general.order_number') }}
                        :</strong>
                    {{ $component->order_number }} </div>
            @endif

            @if ($component->notes)

                <div class="col-md-12">
                    <strong>
                        {{ trans('general.notes') }}
                    </strong>
                </div>
                <div class="col-md-12">
                    {!! nl2br(e($component->notes)) !!}
                </div>
            @endif
        </div>
    </div> <!-- .row-->

    <div class="row">
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table table-responsive">
                                <table class="table table-striped snipe-table" id="serial-table">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Asset</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                        <th>Added</th>
                                        <th>Last Updated</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($component->serials as $serial)
                                        <tr>
                                            <td>
                                                <a href="{{ route('components.serials.edit', $serial->id) }}"
                                                   class="btn btn-default btn-sm pull-right">
                                                    <i class="fa fa-pencil icon-white"></i>
                                                    {{ $serial->serial_number }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($serial->asset)
                                                    <a href="{{ route('hardware.show', $serial->asset->id) }}">
                                                        {{ $serial->asset->asset_tag }}
                                                    </a>
                                                @else
                                                    <span class="label label-danger">Not Assigned</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $serial->status_label }}
                                            </td>
                                            <td>
                                                <textarea readonly="readonly" rows="4" class="form-control">{{ $serial->notes }}</textarea>
                                            </td>
                                            <td>
                                                <span timestamp="{{ $serial->created_at->toISOString() }}" name="__timestamp"></span>
                                            </td>
                                            <td>
                                                {{-- Convert the updated at field to a javascript timestamp using momentjs --}}
                                                <span timestamp="{{ $serial->updated_at->toISOString() }}" name="__timestamp"></span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div> <!-- .col-md-12-->
                    </div>
                </div>
            </div>
        </div> <!-- .col-md-9-->
    </div> <!-- .row-->

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table', ['exportFile' => 'component' . $component->name . '-export', 'search' => false])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="application/javascript">
        $(document).ready(function() {
            let table = $('#serial-table');

            // Update the timestamp fields for each row in the table.
            table.find('span[name="__timestamp"]').each(function() {
                let timestamp = $(this).attr('timestamp');
                $(this).text(moment(timestamp).calendar());
            });
        });
    </script>
@stop
