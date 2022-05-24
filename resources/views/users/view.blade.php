@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/users/general.view_user', ['name' => $user->present()->fullName()]) }}
@parent
@stop

{{-- Page content --}}
@section('content')



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
              {!! ($user->assets->count() > 0 ) ? '<badge class="badge badge-secondary">'.$user->assets->count().'</badge>' : '' !!}
            </span>
          </a>
        </li>

        <li>
          <a href="#licenses" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="far fa-save fa-2x"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('general.licenses') }}
              {!! ($user->licenses->count() > 0 ) ? '<badge class="badge badge-secondary">'.$user->licenses->count().'</badge>' : '' !!}
            </span>
          </a>
        </li>

        <li>
          <a href="#accessories" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="far fa-keyboard fa-2x"></i>
            </span> 
            <span class="hidden-xs hidden-sm">{{ trans('general.accessories') }}
              {!! ($user->accessories->count() > 0 ) ? '<badge class="badge badge-secondary">'.$user->accessories->count().'</badge>' : '' !!}
            </span>
          </a>
        </li>

        <li>
          <a href="#consumables" data-toggle="tab">
            <span class="hidden-lg hidden-md">
                <i class="fas fa-tint fa-2x"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('general.consumables') }}
              {!! ($user->consumables->count() > 0 ) ? '<badge class="badge badge-secondary">'.$user->consumables->count().'</badge>' : '' !!}
            </span>
          </a>
        </li>

        <li>
          <a href="#files" data-toggle="tab">
            <span class="hidden-lg hidden-md">
                <i class="far fa-file fa-2x"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('general.file_uploads') }}
              {!! ($user->uploads->count() > 0 ) ? '<badge class="badge badge-secondary">'.$user->uploads->count().'</badge>' : '' !!}
            </span>
          </a>
        </li>

        <li>
          <a href="#history" data-toggle="tab">
            <span class="hidden-lg hidden-md">
                <i class="fas fa-history fa-2x"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('general.history') }}</span>
          </a>
        </li>

        @if ($user->managedLocations()->count() >= 0 )
        <li>
          <a href="#managed" data-toggle="tab">
            <span class="hidden-lg hidden-md">
              <i class="fas fa-map-marker-alt fa-2x"></i></span>
            <span class="hidden-xs hidden-sm">{{ trans('admin/users/table.managed_locations') }}
              {!! ($user->managedLocations->count() > 0 ) ? '<badge class="badge badge-secondary">'.$user->managedLocations->count().'</badge>' : '' !!}
          </a>
        </li>
        @endif

        @can('update', $user)
          <li class="dropdown pull-right">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <span class="hidden-xs"><i class="fas fa-cog" aria-hidden="true"></i></span>
              <span class="hidden-lg hidden-md hidden-xl"><i class="fas fa-cog fa-2x" aria-hidden="true"></i></span>
              
              <span class="hidden-xs hidden-sm">
                {{ trans('button.actions') }}
              </span>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('users.edit', $user->id) }}">{{ trans('admin/users/general.edit') }}</a></li>
              <li><a href="{{ route('clone/user', $user->id) }}">{{ trans('admin/users/general.clone') }}</a></li>
              @if ((Auth::user()->id !== $user->id) && (!config('app.lock_passwords')) && ($user->deleted_at==''))
                <li><a href="{{ route('users.destroy', $user->id) }}">{{ trans('button.delete') }}</a></li>
              @endif
            </ul>
          </li>
        @endcan

        @can('update', \App\Models\User::class)
          <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal">
              <span class="hidden-xs"><i class="fas fa-paperclip" aria-hidden="true"></i></span>
              <span class="hidden-lg hidden-md hidden-xl"><i class="fas fa-paperclip fa-2x" aria-hidden="true"></i></span>
              <span class="hidden-xs hidden-sm">{{ trans('button.upload') }}</span>
              </a>
          </li>
        @endcan
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="details">
          <div class="row">

            
            @if ($user->deleted_at!='')
              <div class="col-md-12">
                <div class="callout callout-warning">
                  <i class="icon fas fa-exclamation-triangle"></i>
                  {{ trans('admin/users/message.user_deleted_warning') }}
                  @can('update', $user)
                      <a href="{{ route('restore/user', $user->id) }}">
                        {{ trans('admin/users/general.restore_user') }}
                      </a>
                  @endcan
                </div>
              </div>
            @endif

            <!-- Start button column -->
            <div class="col-md-3 col-xs-12 col-sm-push-9">

              

              <div class="col-md-12 text-center">
                
                 @if (($user->isSuperUser()) || ($user->hasAccess('admin')))
                    <i class="fas fa-crown fa-2x {{  ($user->isSuperUser()) ? 'text-danger' : ' text-orange'}}"></i>
                    <div class="{{  ($user->isSuperUser()) ? 'text-danger' : ' text-orange'}}" style="font-weight: bold">{{  ($user->isSuperUser()) ? 'superadmin' : 'admin'}}</div>
                  @endif

                
              </div>
              <div class="col-md-12 text-center">
                <img src="{{ $user->present()->gravatar() }}"  class=" img-thumbnail hidden-print" style="margin-bottom: 20px;" alt="{{ $user->present()->fullName() }}">  
               </div>
               
          

              @can('update', $user)
                <div class="col-md-12">
                  <a href="{{ route('users.edit', $user->id) }}" style="width: 100%;" class="btn btn-sm btn-primary hidden-print">{{ trans('admin/users/general.edit') }}</a>
                </div>
              @endcan

              @can('create', $user)
                <div class="col-md-12" style="padding-top: 5px;">
                  <a href="{{ route('clone/user', $user->id) }}" style="width: 100%;" class="btn btn-sm btn-primary hidden-print">{{ trans('admin/users/general.clone') }}</a>
                </div>
               @endcan

                @can('view', $user)
                <div class="col-md-12" style="padding-top: 5px;">
                  <a href="{{ route('users.print', $user->id) }}" style="width: 100%;" class="btn btn-sm btn-primary hidden-print" target="_blank" rel="noopener">{{ trans('admin/users/general.print_assigned') }}</a>
                </div>
                @endcan

                @can('update', $user)
                  @if (($user->activated == '1') && ($user->email != '') && ($user->ldap_import == '0'))
                      <div class="col-md-12" style="padding-top: 5px;">
                        <form action="{{ route('users.password',['userId'=> $user->id]) }}" method="POST">
                          {{ csrf_field() }}
                          <button style="width: 100%;" class="btn btn-sm btn-primary hidden-print">{{ trans('button.send_password_link') }}</button>
                        </form>
                      </div>
                  @endif
                @endcan

                @can('delete', $user)
                  @if ($user->deleted_at=='')
                    <div class="col-md-12" style="padding-top: 30px;">
                      <form action="{{route('users.destroy',$user->id)}}" method="POST">
                        {{csrf_field()}}
                        {{ method_field("DELETE")}}
                        <button style="width: 100%;" class="btn btn-sm btn-warning hidden-print">{{ trans('button.delete')}}</button>
                      </form>
                    </div>
                    <div class="col-md-12" style="padding-top: 5px;">
                      <form action="{{ route('users/bulkedit') }}" method="POST">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="bulk_actions" value="delete" />

                        <input type="hidden" name="ids[{{ $user->id }}]" value="{{ $user->id }}" />
                        <button style="width: 100%;" class="btn btn-sm btn-danger hidden-print">{{ trans('button.checkin_and_delete') }}</button>
                      </form>
                    </div>
                  @else
                    <div class="col-md-12" style="padding-top: 5px;">
                      <a href="{{ route('restore/user', $user->id) }}" style="width: 100%;" class="btn btn-sm btn-warning hidden-print">{{ trans('button.restore') }}</a>
                    </div>
                  @endif
                @endcan
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
                          <label class="label label-danger">
                              <i class="fas fa-crown" title="superuser"></i>
                          </label>&nbsp;
                        @elseif ($user->hasAccess('admin'))
                          <label class="label label-warning">
                              <i class="fas fa-crown" title="admin"></i>
                          </label>&nbsp;
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

                      </div>
                    </div>
                    @endif


                     <!-- groups -->
                     <div class="row">
                        <div class="col-md-3">
                          {{ trans('general.groups') }}
                        </div>
                        <div class="col-md-9">
                          @if ($user->groups->count() > 0)
                            @foreach ($user->groups as $group)

                              @can('superadmin')
                                  <a href="{{ route('groups.show', $group->id) }}" class="label label-default">{{ $group->name }}</a>
                              @else
                              {{ $group->name }}
                              @endcan

                            @endforeach
                          @else
                              --
                          @endif
                        </div>
                      </div>

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

                    @if ($user->phone)
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
                        <a href="{{ route('departments.show', $user->department) }}">
                          {{ $user->department->name }}
                        </a>
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

                     <!-- login enabled -->
                     <div class="row">
                      <div class="col-md-3">
                        {{ trans('admin/users/general.remote') }}
                      </div>
                      <div class="col-md-9">
                        {!! ($user->remote=='1') ? '<i class="fas fa-check text-success" aria-hidden="true"></i> '.trans('general.yes') : '<i class="fas fa-times text-danger" aria-hidden="true"></i> '.trans('general.no')  !!}
                      </div>
                    </div>

                    <!-- login enabled -->
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.login_enabled') }}
                      </div>
                      <div class="col-md-9">
                        {!! ($user->activated=='1') ? '<i class="fas fa-check text-success" aria-hidden="true"></i> '.trans('general.yes') : '<i class="fas fa-times text-danger" aria-hidden="true"></i> '.trans('general.no')  !!}
                      </div>
                    </div>

                    <!-- LDAP -->
                    <div class="row">
                      <div class="col-md-3">
                          LDAP
                      </div>
                      <div class="col-md-9">
                        {!! ($user->ldap_import=='1') ? '<i class="fas fa-check text-success" aria-hidden="true"></i> '.trans('general.yes') : '<i class="fas fa-times text-danger" aria-hidden="true"></i> '.trans('general.no')  !!}

                      </div>
                    </div>

                    @if ($user->activated == '1')

                          <!-- 2FA active -->
                          <div class="row">
                            <div class="col-md-3">
                              {{ trans('admin/users/general.two_factor_active') }}
                            </div>
                            <div class="col-md-9">
                          
                              {!! ($user->two_factor_active()) ? '<i class="fas fa-check text-success" aria-hidden="true"></i> '.trans('general.yes') : '<i class="fas fa-times text-danger" aria-hidden="true"></i> '.trans('general.no')  !!}
                          
                            </div>
                          </div>
                          
                          <!-- 2FA enrolled -->
                          <div class="row two_factor_resetrow">
                            <div class="col-md-3">
                              {{ trans('admin/users/general.two_factor_enrolled') }}
                            </div>
                            <div class="col-md-9" id="two_factor_reset_toggle">
                              {!! ($user->two_factor_active_and_enrolled()) ? '<i class="fas fa-check text-success" aria-hidden="true"></i> '.trans('general.yes') : '<i class="fas fa-times text-danger" aria-hidden="true"></i> '.trans('general.no')  !!}

                            </div>
                          </div>
                          
                          @if ((Auth::user()->isSuperUser()) && ($snipeSettings->two_factor_enabled!='0') && ($snipeSettings->two_factor_enabled!=''))
                          
                            <!-- 2FA reset -->
                            <div class="row">
                              <div class="col-md-3">
                          
                              </div>
                              <div class="col-md-9" style="margin-top: 10px;">
                                
                                <a class="btn btn-default btn-sm pull-left" id="two_factor_reset" style="margin-right: 10px;"> 
                                  {{ trans('admin/settings/general.two_factor_reset') }}
                                </a>
                                <span id="two_factor_reseticon">
                                </span>
                                <span id="two_factor_resetresult">
                                </span>
                                <span id="two_factor_resetstatus">
                                </span>
                                <br>
                                <p class="help-block" style="line-height: 1.6;">{{ trans('admin/settings/general.two_factor_reset_help') }}</p>
                          
                                
                              </div>
                            </div>
                            @endif 
                  @endif
                    

                    @if ($user->notes)
                     <!-- empty -->
                     <div class="row">

                      <div class="col-md-3">
                        {{ trans('admin/users/table.notes') }}
                      </div>
                      <div class="col-md-9">
                        {{ $user->notes }}
                      </div>

                    </div>
                    @endif

                  </div> <!--/end striped container-->
                </div> <!-- end col-md-9 -->
   
            
            
          </div> <!--/.row-->
        </div><!-- /.tab-pane -->

        <div class="tab-pane" id="asset">
          <!-- checked out assets table -->

            @include('partials.asset-bulk-actions')

            <div class="table table-responsive">

            <table
                    data-click-to-select="true"
                    data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                    data-cookie-id-table="userAssetsListingTable"
                    data-pagination="true"
                    data-id-table="userAssetsListingTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    data-toolbar="#toolbar"
                    id="userAssetsListingTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.assets.index',['assigned_to' => e($user->id), 'assigned_type' => 'App\Models\User']) }}"
                    data-export-options='{
                "fileName": "export-{{ str_slug($user->present()->fullName()) }}-assets-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
            </table>
          </div>
        </div><!-- /asset -->

        <div class="tab-pane" id="licenses">
          <div class="table-responsive">
            <table
                    data-cookie-id-table="userLicenseTable"
                    data-id-table="userLicenseTable"
                    id="userLicenseTable"
                    data-search="true"
                    data-pagination="true"
                    data-side-pagination="client"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    class="table table-striped snipe-table table-hover"
                    data-export-options='{
                    "fileName": "export-license-{{ str_slug($user->username) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>

              <thead>
                <tr>
                  <th class="col-md-5">{{ trans('general.name') }}</th>
                  <th>{{ trans('admin/hardware/form.serial') }}</th>
                  <th data-footer-formatter="sumFormatter" data-fieldname="purchase_cost">{{ trans('general.purchase_cost') }}</th>
                  <th>{{ trans('admin/licenses/form.purchase_order') }}</th>
                  <th>{{ trans('general.order_number') }}</th>
                  <th class="col-md-1 hidden-print">{{ trans('general.action') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($user->licenses as $license)
                <tr>
                  <td class="col-md-4">
                    {!! $license->present()->nameUrl() !!}
                  </td>
                  <td class="col-md-4">
                    @can('viewKeys', $license)
                    {!! $license->present()->serialUrl() !!}
                    @else
                      ------------
                    @endcan
                  </td>
                  <td class="col-md-2">
                    {{ Helper::formatCurrencyOutput($license->purchase_cost) }}
                  </td>
                  <td>
                    {{ $license->purchase_order }}
                  </td>
                  <td>
                    {{ $license->order_number }}
                  </td>
                  <td class="hidden-print col-md-2">
                    @can('update', $license)
                      <a href="{{ route('licenses.checkin', array('licenseSeatId'=> $license->pivot->id, 'backto'=>'user')) }}" class="btn btn-primary btn-sm hidden-print">{{ trans('general.checkin') }}</a>
                     @endcan
                  </td>
                </tr>
                @endforeach
              </tbody>
          </table>
          </div>
        </div><!-- /licenses-tab -->

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
                  <th class="col-md-6" data-footer-formatter="sumFormatter" data-fieldname="purchase_cost">{{ trans('general.purchase_cost') }}</th>
                  <th class="col-md-1 hidden-print">{{ trans('general.action') }}</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($user->accessories as $accessory)
                  <tr>
                    <td>{!!$accessory->present()->nameUrl()!!}</td>
                    <td>
                      {!! Helper::formatCurrencyOutput($accessory->purchase_cost) !!}
                    </td>
                    <td class="hidden-print">
                      @can('checkin', $accessory)
                        <a href="{{ route('checkin/accessory', array('accessoryID'=> $accessory->pivot->id, 'backto'=>'user')) }}" class="btn btn-primary btn-sm hidden-print">{{ trans('general.checkin') }}</a>
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
                  <th class="col-md-6">{{ trans('general.name') }}</th>
                  <th class="col-md-2" data-footer-formatter="sumFormatter" data-fieldname="purchase_cost">{{ trans('general.purchase_cost') }}</th>
                  <th class="col-md-4">{{ trans('general.date') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($user->consumables as $consumable)
                <tr>
                  <td>{!! $consumable->present()->nameUrl() !!}</td>
                  <td>
                    {!! Helper::formatCurrencyOutput($consumable->purchase_cost) !!}
                  </td>
                  <td>{{ $consumable->pivot->created_at }}</td>                      
                </tr>
                @endforeach
              </tbody>
          </table>
          </div>
        </div><!-- /consumables-tab -->

        <div class="tab-pane" id="files">
          <div class="row">

            <div class="col-md-12 col-sm-12">
              <div class="table-responsive">
                  <table
                          data-cookie-id-table="userUploadsTable"
                          data-id-table="userUploadsTable"
                          id="userUploadsTable"
                          data-search="true"
                          data-pagination="true"
                          data-side-pagination="client"
                          data-show-columns="true"
                          data-show-export="true"
                          data-show-footer="true"
                          data-toolbar="#upload-toolbar"
                          data-show-refresh="true"
                          data-sort-order="asc"
                          data-sort-name="name"
                          class="table table-striped snipe-table"
                          data-export-options='{
                    "fileName": "export-license-uploads-{{ str_slug($user->name) }}-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","delete","download","icon"]
                    }'>

                  <thead>
                    <tr>
                        <th data-visible="true" data-field="icon" data-sortable="true">{{trans('general.file_type')}}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="image">{{ trans('general.image') }}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="filename" data-sortable="true">{{ trans('general.file_name') }}</th>
                        <th class="col-md-1" data-searchable="true" data-visible="true" data-field="filesize">{{ trans('general.filesize') }}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="notes" data-sortable="true">{{ trans('general.notes') }}</th>
                        <th class="col-md-1" data-searchable="true" data-visible="true" data-field="download">{{ trans('general.download') }}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="created_at" data-sortable="true">{{ trans('general.created_at') }}</th>
                        <th class="col-md-1" data-searchable="true" data-visible="true" data-field="actions">{{ trans('table.actions') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($user->uploads as $file)
                        <tr>
                            <td>
                                <i class="{{ Helper::filetype_icon($file->filename) }} icon-med" aria-hidden="true"></i>
                                <span class="sr-only">{{ Helper::filetype_icon($file->filename) }}</span>

                            </td>
                            <td>
                                @if ($file->filename)
                                    @if ( Helper::checkUploadIsImage($file->get_src('users')))
                                        <a href="{{ route('show/userfile', ['userId' => $user->id, 'fileId' => $file->id, 'download' => 'false']) }}" data-toggle="lightbox" data-type="image"><img src="{{ route('show/userfile', ['userId' => $user->id, 'fileId' => $file->id]) }}" class="img-thumbnail" style="max-width: 50px;"></a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                {{ $file->filename }}
                            </td>
                            <td>
                                {{ Helper::formatFilesizeUnits(filesize(storage_path('private_uploads/users/').$file->filename)) }}
                            </td>

                            <td>
                                @if ($file->note)
                                    {{ $file->note }}
                                @endif
                            </td>
                            <td>
                                @if ($file->filename)
                                    <a href="{{ route('show/userfile', [$user->id, $file->id]) }}" class="btn btn-default">
                                        <i class="fas fa-download" aria-hidden="true"></i>
                                        <span class="sr-only">{{ trans('general.download') }}</span>
                                    </a>
                                @endif
                            </td>
                            <td>{{ $file->created_at }}</td>

                            <td>
                                <a class="btn delete-asset btn-danger btn-sm hidden-print" href="{{ route('userfile.destroy', [$user->id, $file->id]) }}" data-content="Are you sure you wish to delete this file?" data-title="Delete {{ $file->filename }}?">
                                    <i class="fa fa-trash icon-white" aria-hidden="true"></i>
                                    <span class="sr-only">{{ trans('general.delete') }}</span>
                                </a>
                            </td>



                        </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>
            </div>
          </div> <!--/ROW-->
        </div><!--/FILES-->

        <div class="tab-pane" id="history">
          <div class="table-responsive">


            <table
                    data-click-to-select="true"
                    data-cookie-id-table="usersHistoryTable"
                    data-pagination="true"
                    data-id-table="usersHistoryTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="desc"
                    id="usersHistoryTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.activity.index', ['target_id' => $user->id, 'target_type' => 'user']) }}"
                    data-export-options='{
                "fileName": "export-{{ str_slug($user->present()->fullName ) }}-history-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
              <thead>
              <tr>
                <th data-field="icon" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter">Icon</th>
                <th class="col-sm-3" data-field="created_at" data-formatter="dateDisplayFormatter" data-sortable="true">{{ trans('general.date') }}</th>
                <th class="col-sm-2" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                <th class="col-sm-2" data-field="action_type">{{ trans('general.action') }}</th>
                <th class="col-sm-3" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                <th class="col-sm-2" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
              </tr>
              </thead>
            </table>

          </div>
        </div><!-- /.tab-pane -->

        <div class="tab-pane" id="managed">
          <div class="table-responsive">
            <table class="table display table-striped">
              <thead>
                <tr>
                  <th class="col-md-8">{{ trans('general.name') }}</th>
                  <th class="col-md-4">{{ trans('general.date') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($user->managedLocations as $location)
                <tr>
                  <td>{!! $location->present()->nameUrl() !!}</td>
                  <td>{{ $location->created_at }}</td>
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

  @can('update', \App\Models\User::class)
    @include ('modals.upload-file', ['item_type' => 'user', 'item_id' => $user->id])
  @endcan



  @stop

@section('moar_scripts')
  @include ('partials.bootstrap-table', ['simple_view' => true])
<script nonce="{{ csrf_token() }}">
$(function () {

  $("#two_factor_reset").click(function(){
    $("#two_factor_resetrow").removeClass('success');
    $("#two_factor_resetrow").removeClass('danger');
    $("#two_factor_resetstatus").html('');
    $("#two_factor_reseticon").html('<i class="fas fa-spinner spin"></i>');
    $.ajax({
      url: '{{ route('api.users.two_factor_reset', ['id'=> $user->id]) }}',
      type: 'POST',
      data: {},
      headers: {
        "X-Requested-With": 'XMLHttpRequest',
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',

      success: function (data) {
        $("#two_factor_reset_toggle").html('').html('<i class="fas fa-times text-danger" aria-hidden="true"></i> {{ trans('general.no') }}');
        $("#two_factor_reseticon").html('');
        $("#two_factor_resetstatus").html('<i class="fas fa-check text-success"></i>' + data.message);

      },

      error: function (data) {
        $("#two_factor_reseticon").html('');
        $("#two_factor_reseticon").html('<i class="fas fa-exclamation-triangle text-danger"></i>');
        $('#two_factor_resetstatus').text(data.message);
      }


    });
  });


    //binds to onchange event of your input field
    var uploadedFileSize = 0;
    $('#fileupload').bind('change', function() {
      uploadedFileSize = this.files[0].size;
      $('#progress-container').css('visibility', 'visible');
    });

    $('#fileupload').fileupload({
        //maxChunkSize: 100000,
        dataType: 'json',
        formData:{
        _token:'{{ csrf_token() }}',
        notes: $('#notes').val(),
        },

        progress: function (e, data) {
            //var overallProgress = $('#fileupload').fileupload('progress');
            //var activeUploads = $('#fileupload').fileupload('active');
            var progress = parseInt((data.loaded / uploadedFileSize) * 100, 10);
            $('.progress-bar').addClass('progress-bar-warning').css('width',progress + '%');
            $('#progress-bar-text').html(progress + '%');
            //console.dir(overallProgress);
        },

        done: function (e, data) {
            console.dir(data);
            // We use this instead of the fail option, since our API
            // returns a 200 OK status which always shows as "success"

            if (data && data.jqXHR && data.jqXHR.responseJSON && data.jqXHR.responseJSON.status === "error") {
                var errorMessage = data.jqXHR.responseJSON.messages["file.0"];
                $('#progress-bar-text').html(errorMessage[0]);
                $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-danger').css('width','100%');
                $('.progress-checkmark').fadeIn('fast').html('<i class="fas fa-times fa-3x icon-white" style="color: #d9534f"></i>');
            } else {
                $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-success').css('width','100%');
                $('.progress-checkmark').fadeIn('fast');
                $('#progress-container').delay(950).css('visibility', 'visible');
                $('.progress-bar-text').html('Finished!');
                $('.progress-checkmark').fadeIn('fast').html('<i class="fas fa-check fa-3x icon-white" style="color: green"></i>');
                $.each(data.result, function (index, file) {
                    $('<tr><td>' + file.note + '</td><<td>' + file.filename + '</td></tr>').prependTo("#files-table > tbody");
                });
            }
            $('#progress').removeClass('active');


        }
    });
});
</script>


@stop
