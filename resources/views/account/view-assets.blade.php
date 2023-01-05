@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.hello_name', array('name' => $user->present()->fullName())) }}
@parent
@stop

{{-- Account page content --}}
@section('content')

@if ($acceptances = \App\Models\CheckoutAcceptance::forUser(Auth::user())->pending()->count())
  <div class="col-md-12">
    <div class="alert alert alert-warning fade in">
      <i class="fas fa-exclamation-triangle faa-pulse animated"></i>

      <strong>
        <a href="{{ route('account.accept') }}" style="color: white;">
          {{ trans('general.unaccepted_profile_warning', array('count' => $acceptances)) }}
        </a>
        </strong>
    </div>
  </div>
@endif

  <div class="row">
    <div class="col-md-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs hidden-print">

          <li class="active">
            <a href="#details" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fas fa-info-circle fa-2x"></i>
            </span>
              <span class="hidden-xs hidden-sm">{{ trans('admin/users/general.info') }}</span>
            </a>
          </li>

          <li>
            <a href="#asset" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fas fa-barcode fa-2x" aria-hidden="true"></i>
            </span>
              <span class="hidden-xs hidden-sm">{{ trans('general.assets') }}
                {!! ($user->assets()->AssetsForShow()->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($user->assets()->AssetsForShow()->count()).'</badge>' : '' !!}
            </span>
            </a>
          </li>

          <li>
            <a href="#licenses" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="far fa-save fa-2x"></i>
            </span>
              <span class="hidden-xs hidden-sm">{{ trans('general.licenses') }}
                {!! ($user->licenses->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($user->licenses->count()).'</badge>' : '' !!}
            </span>
            </a>
          </li>

          <li>
            <a href="#accessories" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="far fa-keyboard fa-2x"></i>
            </span>
              <span class="hidden-xs hidden-sm">{{ trans('general.accessories') }}
                {!! ($user->accessories->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($user->accessories->count()).'</badge>' : '' !!}
            </span>
            </a>
          </li>

          <li>
            <a href="#consumables" data-toggle="tab">
            <span class="hidden-lg hidden-md">
                <i class="fas fa-tint fa-2x"></i>
            </span>
              <span class="hidden-xs hidden-sm">{{ trans('general.consumables') }}
                {!! ($user->consumables->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($user->consumables->count()).'</badge>' : '' !!}
            </span>
            </a>
          </li>

        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="details">
            <div class="row">


              <!-- Start button column -->
              <div class="col-md-3 col-xs-12 col-sm-push-9">



                <div class="col-md-12 text-center">

                </div>
                <div class="col-md-12 text-center">
                  <img src="{{ $user->present()->gravatar() }}"  class=" img-thumbnail hidden-print" style="margin-bottom: 20px;" alt="{{ $user->present()->fullName() }}">
                </div>

                  <div class="col-md-12">
                    <a href="{{ route('profile') }}" style="width: 100%;" class="btn btn-sm btn-primary hidden-print">
                      {{ trans('general.editprofile') }}
                    </a>
                  </div>

                <div class="col-md-12" style="padding-top: 5px;">
                  <a href="{{ route('account.password.index') }}" style="width: 100%;" class="btn btn-sm btn-primary hidden-print" target="_blank" rel="noopener">
                    {{ trans('general.changepassword') }}
                  </a>
                </div>

                @can('self.api')
                <div class="col-md-12" style="padding-top: 5px;">
                  <a href="{{ route('user.api') }}" style="width: 100%;" class="btn btn-sm btn-primary hidden-print" target="_blank" rel="noopener">
                    {{ trans('general.manage_api_keys') }}
                  </a>
                </div>
                @endcan


                  <div class="col-md-12" style="padding-top: 5px;">
                    <a href="{{ route('profile.print') }}" style="width: 100%;" class="btn btn-sm btn-primary hidden-print" target="_blank" rel="noopener">
                      {{ trans('admin/users/general.print_assigned') }}
                    </a>
                  </div>


                  <div class="col-md-12" style="padding-top: 5px;">
                    @if (!empty($user->email))
                      <form action="{{ route('profile.email_assets') }}" method="POST">
                        {{ csrf_field() }}
                        <button style="width: 100%;" class="btn btn-sm btn-primary hidden-print" rel="noopener">{{ trans('admin/users/general.email_assigned') }}</button>
                      </form>
                    @else
                      <button style="width: 100%;" class="btn btn-sm btn-primary hidden-print" rel="noopener" disabled title="{{ trans('admin/users/message.user_has_no_email') }}">{{ trans('admin/users/general.email_assigned') }}</button>
                    @endif
                  </div>

                <br><br>
              </div>

              <!-- End button column -->

              <div class="col-md-9 col-xs-12 col-sm-pull-3">

                <div class="row-new-striped">

                  <div class="row">
                    <!-- name -->

                    <div class="col-md-3 col-sm-2">
                      {{ trans('admin/users/table.name') }}
                    </div>
                    <div class="col-md-9 col-sm-2">
                      {{ $user->present()->fullName() }}
                    </div>

                  </div>



                  <!-- company -->
                  @if (!is_null($user->company))
                    <div class="row">

                      <div class="col-md-3">
                        {{ trans('general.company') }}
                      </div>
                      <div class="col-md-9">
                        {{ $user->company->name }}
                      </div>

                    </div>

                  @endif

                  <!-- username -->
                  <div class="row">

                    <div class="col-md-3">
                      {{ trans('admin/users/table.username') }}
                    </div>
                    <div class="col-md-9">

                      @if ($user->isSuperUser())
                        <label class="label label-danger"><i class="fas fa-crown" title="superuser"></i></label>&nbsp;
                      @elseif ($user->hasAccess('admin'))
                        <label class="label label-warning"><i class="fas fa-crown" title="admin"></i></label>&nbsp;
                      @endif
                      {{ $user->username }}

                    </div>

                  </div>

                  <!-- address -->
                  @if (($user->address) || ($user->city) || ($user->state) || ($user->country))
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.address') }}
                      </div>
                      <div class="col-md-9">

                        @if ($user->address)
                          {{ $user->address }} <br>
                        @endif
                        @if ($user->city)
                          {{ $user->city }}
                        @endif
                        @if ($user->state)
                          {{ $user->state }}
                        @endif
                        @if ($user->country)
                          {{ $user->country }}
                        @endif
                        @if ($user->zip)
                          {{ $user->zip }}
                        @endif

                      </div>
                    </div>
                  @endif

                  @if ($user->jobtitle)
                    <!-- jobtitle -->
                    <div class="row">

                      <div class="col-md-3">
                        {{ trans('admin/users/table.job') }}
                      </div>
                      <div class="col-md-9">
                        {{ $user->jobtitle }}
                      </div>

                    </div>
                  @endif

                  @if ($user->employee_num)
                    <!-- employee_num -->
                    <div class="row">

                      <div class="col-md-3">
                        {{ trans('admin/users/table.employee_num') }}
                      </div>
                      <div class="col-md-9">
                        {{ $user->employee_num }}
                      </div>

                    </div>
                  @endif

                  @if ($user->manager)
                    <!-- manager -->
                    <div class="row">

                      <div class="col-md-3">
                        {{ trans('admin/users/table.manager') }}
                      </div>
                      <div class="col-md-9">
                        <a href="{{ route('users.show', $user->manager->id) }}">
                          {{ $user->manager->getFullNameAttribute() }}
                        </a>
                      </div>

                    </div>

                  @endif


                  @if ($user->email)
                    <!-- email -->
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('admin/users/table.email') }}
                      </div>
                      <div class="col-md-9">
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                      </div>
                    </div>
                  @endif

                  @if ($user->website)
                    <!-- website -->
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.website') }}
                      </div>
                      <div class="col-md-9">
                        <a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a>
                      </div>
                    </div>
                  @endif

                  @if ($user->phone)
                    <!-- phone -->
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('admin/users/table.phone') }}
                      </div>
                      <div class="col-md-9">
                        <a href="tel:{{ $user->phone }}">{{ $user->phone }}</a>
                      </div>
                    </div>
                  @endif

                  @if ($user->userloc)
                    <!-- location -->
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('admin/users/table.location') }}
                      </div>
                      <div class="col-md-9">
                        {{ link_to_route('locations.show', $user->userloc->name, [$user->userloc->id]) }}
                      </div>
                    </div>
                  @endif

                  <!-- last login -->
                  <div class="row">
                    <div class="col-md-3">
                      {{ trans('general.last_login') }}
                    </div>
                    <div class="col-md-9">
                      {{ \App\Helpers\Helper::getFormattedDateObject($user->last_login, 'datetime', false) }}
                    </div>
                  </div>


                  @if ($user->department)
                    <!-- empty -->
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.department') }}
                      </div>
                      <div class="col-md-9">
                          {{ $user->department->name }}
                      </div>
                    </div>
                  @endif

                  @if ($user->created_at)
                    <!-- created at -->
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.created_at') }}
                      </div>
                      <div class="col-md-9">
                        {{ \App\Helpers\Helper::getFormattedDateObject($user->created_at, 'datetime')['formatted']}}
                      </div>
                    </div>
                  @endif

                </div> <!--/end striped container-->
              </div> <!-- end col-md-9 -->



            </div> <!--/.row-->
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="asset">
            <!-- checked out assets table -->


            <div class="table table-responsive">
              @if ($user->id)
                <div class="box-header with-border">
                  <div class="box-heading">
                    <h2 class="box-title"> {{ trans('admin/users/general.assets_user', array('name' => $user->first_name)) }}</h2>
                  </div>
                </div><!-- /.box-header -->
              @endif

              <div class="box-body">
                <!-- checked out assets table -->
                <div class="table-responsive">

                  <table
                          data-cookie="true"
                          data-cookie-id-table="userAssets"
                          data-pagination="true"
                          data-id-table="userAssets"
                          data-search="true"
                          data-side-pagination="client"
                          data-show-columns="true"
                          data-show-export="true"
                          data-show-footer="true"
                          data-show-refresh="true"
                          data-sort-order="asc"
                          id="userAssets"
                          class="table table-striped snipe-table"
                          data-export-options='{
                  "fileName": "my-assets-{{ date('Y-m-d') }}",
                  "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                  }'>
                    <thead>
                    <tr>
                      <th class="col-md-1">#</th>
                      <th class="col-md-1">{{ trans('general.image') }}</th>
                      <th class="col-md-2" data-switchable="true" data-visible="true">{{ trans('general.category') }}</th>
                      <th class="col-md-2" data-switchable="true" data-visible="true">{{ trans('admin/hardware/table.asset_tag') }}</th>
                      <th class="col-md-2" data-switchable="true" data-visible="true">{{ trans('general.name') }}</th>
                      <th class="col-md-2" data-switchable="true" data-visible="true">{{ trans('admin/hardware/table.asset_model') }}</th>
                      <th class="col-md-3" data-switchable="true" data-visible="true">{{ trans('admin/hardware/table.serial') }}</th>
                      @can('self.view_purchase_cost')
                        <th class="col-md-6" data-footer-formatter="sumFormatter" data-fieldname="purchase_cost">{{ trans('general.purchase_cost') }}</th>
                      @endcan
                      @foreach ($field_array as $db_column => $field_name)
                        <th class="col-md-1" data-switchable="true" data-visible="true">{{ $field_name }}</th>
                      @endforeach

                    </tr>

                    </thead>
                    <tbody>
                    @php
                      $counter = 1
                    @endphp
                    @foreach ($user->assets as $asset)
                      <tr>
                        <td>{{ $counter }}</td>
                        <td>
                          @if (($asset->image) && ($asset->image!=''))
                            <img src="{{ Storage::disk('public')->url(app('assets_upload_path').e($asset->image)) }}" style="max-height: 30px; width: auto" class="img-responsive">
                          @elseif (($asset->model) && ($asset->model->image!=''))
                            <img src="{{ Storage::disk('public')->url(app('models_upload_path').e($asset->model->image)) }}" style="max-height: 30px; width: auto" class="img-responsive">
                          @endif
                        </td>
                        <td>
                          @if (($asset->model) && ($asset->model->category))
                          {{ $asset->model->category->name }}
                          @endif
                        </td>
                        <td>{{ $asset->asset_tag }}</td>
                        <td>{{ $asset->name }}</td>
                        <td>
                          @if ($asset->physical=='1')
                            {{ $asset->model->name }}
                          @endif
                        </td>
                        <td>{{ $asset->serial }}</td>

                        @can('self.view_purchase_cost')
                        <td>
                          {!! Helper::formatCurrencyOutput($asset->purchase_cost) !!}
                        </td>
                        @endcan

                        @foreach ($field_array as $db_column => $field_value)
                          <td>
                            {{ $asset->{$db_column} }}
                          </td>
                        @endforeach

                      </tr>

                      @php
                        $counter++
                      @endphp
                    @endforeach
                    </tbody>
                  </table>
                </div>
                </div> <!-- .table-responsive-->
            </div>
          </div><!-- /asset -->
          <div class="tab-pane" id="licenses">

            <div class="table-responsive">
              <table
                      data-cookie-id-table="userLicenses"
                      data-pagination="true"
                      data-id-table="userLicenses"
                      data-search="true"
                      data-side-pagination="client"
                      data-show-columns="true"
                      data-show-export="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      id="userLicenses"
                      class="table table-striped snipe-table"
                      data-export-options='{
                    "fileName": "my-licenses-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
                <thead>
                <tr>
                  <th class="col-md-4">{{ trans('general.name') }}</th>
                  <th class="col-md-4">{{ trans('admin/hardware/form.serial') }}</th>
                  <th class="col-md-4">{{ trans('general.category') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user->licenses as $license)
                  <tr>
                    <td>{{ $license->name }}</td>
                    <td>
                      @can('viewKeys', $license)
                        {{ $license->serial }}
                      @else
                        ------------
                      @endcan
                    </td>
                    <td>{{ $license->category->name }}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div> <!-- .table-responsive-->
          </div>

          <div class="tab-pane" id="accessories">
            <div class="table-responsive">
              <table
                      data-cookie-id-table="userAccessoryTable"
                      data-id-table="userAccessoryTable"
                      id="userAccessoryTable"
                      data-search="true"
                      data-pagination="true"
                      data-side-pagination="client"
                      data-show-columns="true"
                      data-show-fullscreen="true"
                      data-show-export="true"
                      data-show-footer="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      data-sort-name="name"
                      class="table table-striped snipe-table table-hover"
                      data-export-options='{
                    "fileName": "export-accessory-{{ str_slug($user->username) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>
                <thead>
                <tr>
                  <th class="col-md-5">{{ trans('general.name') }}</th>
                  @can('self.view_purchase_cost')
                    <th class="col-md-6" data-footer-formatter="sumFormatter" data-fieldname="purchase_cost">{{ trans('general.purchase_cost') }}</th>
                  @endcan
                  <th class="col-md-1 hidden-print">{{ trans('general.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user->accessories as $accessory)
                  <tr>
                    <td>{{ $accessory->name }}</td>
                    @can('self.view_purchase_cost')
                      <td>
                        {!! Helper::formatCurrencyOutput($accessory->purchase_cost) !!}
                      </td>
                    @endcan
                    <td class="hidden-print">
                      @can('checkin', $accessory)
                        <a href="{{ route('accessories.checkin.show', array('accessoryID'=> $accessory->pivot->id, 'backto'=>'user')) }}" class="btn btn-primary btn-sm hidden-print">{{ trans('general.checkin') }}</a>
                      @endcan
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div><!-- /accessories-tab -->

          <div class="tab-pane" id="consumables">
            <div class="table-responsive">
              <table
                      data-cookie-id-table="userConsumableTable"
                      data-id-table="userConsumableTable"
                      id="userConsumableTable"
                      data-search="true"
                      data-pagination="true"
                      data-side-pagination="client"
                      data-show-columns="true"
                      data-show-fullscreen="true"
                      data-show-export="true"
                      data-show-footer="true"
                      data-show-refresh="true"
                      data-sort-order="asc"
                      data-sort-name="name"
                      class="table table-striped snipe-table table-hover"
                      data-export-options='{
                    "fileName": "export-consumable-{{ str_slug($user->username) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>
                <thead>
                <tr>
                  <th class="col-md-3">{{ trans('general.name') }}</th>
                  @can('self.view_purchase_cost')
                    <th class="col-md-2" data-footer-formatter="sumFormatter" data-fieldname="purchase_cost">{{ trans('general.purchase_cost') }}</th>
                  @endcan
                  <th class="col-md-2">{{ trans('general.date') }}</th>
                  <th class="col-md-5">{{ trans('general.notes') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user->consumables as $consumable)
                  <tr>
                    <td>{{ $consumable->name }}</td>
                    @can('self.view_purchase_cost')
                      <td>
                        {!! Helper::formatCurrencyOutput($consumable->purchase_cost) !!}
                      </td>
                    @endcan
                    <td>{{ Helper::getFormattedDateObject($consumable->pivot->created_at, 'datetime',  false) }}</td>
                    <td>{{ $consumable->pivot->note }}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div><!-- /consumables-tab -->

        </div><!-- /.tab-content -->
      </div><!-- nav-tabs-custom -->
    </div>
  </div>







@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop
