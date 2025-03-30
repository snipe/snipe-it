@extends('layouts/default')

{{-- Page title --}}
@section('title')
  {{ $consumable->name }}
  {{ trans('general.consumable') }} -
  ({{ trans('general.remaining_var', ['count' => $consumable->numRemaining()])  }})
  @parent
@endsection

@section('header_right')
  <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
    {{ trans('general.back') }}</a>
@endsection

{{-- Page content --}}
@section('content')




  <div class="row">
    <div class="col-md-12">
      <div class="nav-tabs-custom">
        <!-- Custom Tabs -->
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
              <a href="#checkedout" data-toggle="tab">
                <span class="hidden-lg hidden-md">
                <x-icon type="users" class="fa-2x" />
                </span>
                    <span class="hidden-xs hidden-sm">{{ trans('general.assigned') }}
                      {!! ($consumable->users_consumables > 0 ) ? '<badge class="badge badge-secondary">'.number_format($consumable->users_consumables).'</badge>' : '' !!}
                    </span>
                  </a>
            </li>


            @can('consumables.files', $consumable)
              <li>
                <a href="#files" data-toggle="tab">
                <span class="hidden-lg hidden-md">
                  <i class="far fa-file fa-2x" aria-hidden="true"></i>
                </span>
                <span class="hidden-xs hidden-sm">{{ trans('general.file_uploads') }}
                    {!! ($consumable->uploads->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($consumable->uploads->count()).'</badge>' : '' !!}
                  </span>
                </a>
              </li>
            @endcan

            <li>
              <a href="#history" data-toggle="tab">
                <span class="hidden-lg hidden-md">
                  <i class="fas fa-history fa-2x" aria-hidden="true"></i>
                </span>
                <span class="hidden-xs hidden-sm">
                  {{ trans('general.history') }}
                </span>
              </a>
            </li>

            @can('update', $consumable)
              <li class="pull-right">
                <a href="#" data-toggle="modal" data-target="#uploadFileModal">
                  <x-icon type="paperclip" /> {{ trans('button.upload') }}
                </a>
              </li>
            @endcan

          </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="details">
            <div class="row">
              <div class="info-stack-container">
              <!-- Start button column -->
              <div class="col-md-3 col-xs-12 col-sm-push-9 info-stack">

                @if ($consumable->image!='')
                  <div class="col-md-12 text-center" style="padding-bottom: 20px;">
                    <a href="{{ Storage::disk('public')->url('consumables/'.e($consumable->image)) }}" data-toggle="lightbox" data-type="image">
                      <img src="{{ Storage::disk('public')->url('consumables/'.e($consumable->image)) }}" class="img-responsive img-thumbnail" alt="{{ $consumable->name }}"></a>
                  </div>
                @endif

                
                @can('update', $consumable)
                  <div class="col-md-12">
                    <a href="{{ route('consumables.edit', $consumable->id) }}" style="margin-bottom:5px;"  class="btn btn-sm btn-block btn-social btn-warning hidden-print">
                      <x-icon type="edit" />
                      {{ trans('button.edit') }}
                    </a>
                  </div>
                @endcan

                  @can('checkout', $consumable)
                    @if ($consumable->numRemaining() > 0)
                      <div class="col-md-12">
                        <a href="{{ route('consumables.checkout.show', $consumable->id) }}" style="margin-bottom:5px;" class="btn btn-sm btn-block bg-maroon btn-social hidden-print">
                          <x-icon type="checkout" />
                          {{ trans('general.checkout') }}
                        </a>
                      </div>
                    @else
                      <div class="col-md-12">
                        <button style="margin-bottom:10px;" class="btn btn-block bg-maroon btn-sm btn-social hidden-print disabled">
                          <x-icon type="checkout" />
                          {{ trans('general.checkout') }}
                        </button>
                      </div>
                    @endif
                  @endif


                @can('create', Consumable::class)

                    <div class="col-md-12">
                      <a href="{{ route('consumables.clone.create', $consumable->id) }}" style="margin-bottom:5px;"  class="btn btn-sm btn-block btn-info btn-social hidden-print">
                        <x-icon type="clone" />
                        {{ trans('button.var.clone', ['item_type' => trans('general.consumable')]) }}
                      </a>
                    </div>

                  @endcan



                  @can('delete', $consumable)
                    <div class="col-md-12" style="padding-top: 10px; padding-bottom: 20px">
                      @if ($consumable->deleted_at=='')
                        <button class="btn btn-sm btn-block btn-danger btn-social hidden-print delete-asset" data-toggle="modal" data-title="{{ trans('general.delete') }}" data-content="{{ trans('general.sure_to_delete_var', ['item' => $consumable->name]) }}" data-target="#dataConfirmModal">
                          <x-icon type="delete" />
                          {{ trans('general.delete') }}
                        </button>
                        <span class="sr-only">{{ trans('general.delete') }}</span>
                      @endif
                    </div>
                  @endcan
              </div>

              <!-- End button column -->

              <div class="col-md-9 col-xs-12 col-sm-pull-3 info-stack">

                <div class="row-new-striped" style="margin: 0px;">

                  <div class="row row-new-striped">
                    <!-- name -->
                    <div class="col-md-3 col-sm-2">
                      {{ trans('admin/users/table.name') }}
                    </div>
                    <div class="col-md-9 col-sm-2">
                      {{ $consumable->name }}
                    </div>
                  </div>

                  <!-- company -->
                  @if ($consumable->company)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.company') }}
                      </div>
                      <div class="col-md-9">
                        {{ $consumable->company->name }}
                      </div>
                    </div>
                  @endif

                  <!-- category -->
                  @if ($consumable->category)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.category') }}
                      </div>
                      <div class="col-md-9">
                        {{ $consumable->category->name }}
                      </div>
                    </div>
                  @endif


                  <!-- remaining -->
                  @if ($consumable->numRemaining())
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.remaining') }}
                      </div>
                      <div class="col-md-9">
                        @if ($consumable->numRemaining() < (int) $consumable->min_amt)
                          <i class="fas fa-exclamation-triangle text-orange"
                             aria-hidden="true"
                             data-tooltip="true"
                             data-placement="top"
                             title="{{ trans('admin/consumables/general.inventory_warning', ['min_count' => (int) $consumable->min_amt]) }}">
                          </i>
                        @endif
                        {{ $consumable->numRemaining() }}
                      </div>
                    </div>
                  @endif

                  <!-- min amt -->
                  @if ($consumable->min_amt)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.min_amt') }}
                      </div>
                      <div class="col-md-9">
                        {{ $consumable->min_amt }}
                      </div>
                    </div>
                  @endif

                  <!-- locationm -->
                  @if ($consumable->location)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.location') }}
                      </div>
                      <div class="col-md-9">
                        {{ $consumable->location->name }}
                      </div>
                    </div>
                  @endif

                  <!-- supplier -->
                  @if ($consumable->supplier)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.supplier') }}
                      </div>
                      <div class="col-md-9">
                        {{ $consumable->supplier->name }}
                      </div>
                    </div>
                  @endif

                  <!-- supplier -->
                  @if ($consumable->manufacturer)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.manufacturer') }}
                      </div>
                      <div class="col-md-9">
                        {{ $consumable->manufacturer->name }}
                      </div>
                    </div>
                  @endif

                  @if ($consumable->purchase_cost)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.purchase_cost') }}
                      </div>
                      <div class="col-md-9">
                        {{ $snipeSettings->default_currency }}
                        {{ Helper::formatCurrencyOutput($consumable->purchase_cost) }}
                      </div>
                    </div>
                  @endif

                  @if ($consumable->order_number)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.order_number') }}
                      </div>
                      <div class="col-md-9">
                        <span class="js-copy">{{ $consumable->order_number  }}</span>
                        <i class="fa-regular fa-clipboard js-copy-link" data-clipboard-target=".js-copy" aria-hidden="true" data-tooltip="true" data-placement="top" title="{{ trans('general.copy_to_clipboard') }}">
                          <span class="sr-only">{{ trans('general.copy_to_clipboard') }}</span>
                        </i>

                      </div>
                    </div>
                  @endif

                  @if ($consumable->item_no)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('admin/consumables/general.item_no') }}
                      </div>
                      <div class="col-md-9">

                        <span class="js-copy">{{ $consumable->item_no  }}</span>
                        <i class="fa-regular fa-clipboard js-copy-link" data-clipboard-target=".js-copy" aria-hidden="true" data-tooltip="true" data-placement="top" title="{{ trans('general.copy_to_clipboard') }}">
                          <span class="sr-only">{{ trans('general.copy_to_clipboard') }}</span>
                        </i>

                      </div>
                    </div>
                  @endif

                  @if ($consumable->model_number)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.model_no') }}
                      </div>
                      <div class="col-md-9">

                        <span class="js-copy">{{ $consumable->model_number  }}</span>
                        <i class="fa-regular fa-clipboard js-copy-link" data-clipboard-target=".js-copy" aria-hidden="true" data-tooltip="true" data-placement="top" title="{{ trans('general.copy_to_clipboard') }}">
                          <span class="sr-only">{{ trans('general.copy_to_clipboard') }}</span>
                        </i>

                      </div>
                    </div>
                  @endif

                  <!-- purchase date -->
                  @if ($consumable->purchase_date)
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.purchase_date') }}
                      </div>
                      <div class="col-md-9">
                        {{ \App\Helpers\Helper::getFormattedDateObject($consumable->purchase_date, 'datetime', false) }}
                      </div>
                    </div>
                  @endif

                  @if ($consumable->created_at)
                    <!-- created at -->
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.created_at') }}
                      </div>
                      <div class="col-md-9">
                        {{ \App\Helpers\Helper::getFormattedDateObject($consumable->created_at, 'datetime')['formatted']}}
                      </div>
                    </div>
                  @endif

                  @if ($consumable->updated_at)
                    <!-- created at -->
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.updated_at') }}
                      </div>
                      <div class="col-md-9">
                        {{ \App\Helpers\Helper::getFormattedDateObject($consumable->updated_at, 'datetime')['formatted']}}
                      </div>
                    </div>
                  @endif

                  @if ($consumable->admin)
                    <!-- created at -->
                    <div class="row">
                      <div class="col-md-3">
                        {{ trans('general.created_by') }}
                      </div>
                      <div class="col-md-9">

                          @if ($consumable->admin->deleted_at == '')
                            <a href="{{ route('users.show', ['user' => $consumable->admin]) }}">{{ $consumable->admin->present()->fullName }}</a>
                          @else
                            <del>{{ $consumable->admin->present()->fullName }}</del>
                          @endif

                      </div>
                    </div>
                  @endif

                  @if ($consumable->notes)
                    <!-- empty -->
                    <div class="row">

                      <div class="col-md-3">
                        {{ trans('admin/users/table.notes') }}
                      </div>
                      <div class="col-md-9">
                        {!! nl2br(Helper::parseEscapedMarkedownInline($consumable->notes)) !!}
                      </div>

                    </div>
                  @endif
                </div> <!--/end striped container-->
              </div> <!-- end col-md-9 -->
              </div><!-- end info-stack-container -->
            </div> <!--/.row-->
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="checkedout">

            <table
                    data-cookie-id-table="consumablesCheckedoutTable"
                    data-pagination="true"
                    data-id-table="consumablesCheckedoutTable"
                    data-search="false"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-footer="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="consumablesCheckedoutTable"
                    class="table table-striped snipe-table"
                    data-url="{{route('api.consumables.show.users', $consumable->id)}}"
                    data-export-options='{
                "fileName": "export-consumables-{{ str_slug($consumable->name) }}-checkedout-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
              <thead>
              <tr>
                <th data-searchable="false" data-sortable="false" data-field="avatar" data-formatter="imageFormatter">{{ trans('general.image') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="name" formatter="usersLinkFormatter">{{ trans('general.user') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="created_at" data-formatter="dateDisplayFormatter">
                  {{ trans('general.date') }}
                </th>
                <th data-searchable="false" data-sortable="false" data-field="note">{{ trans('general.notes') }}</th>
                <th data-searchable="false" data-sortable="false" data-field="admin">{{ trans('general.admin') }}</th>
              </tr>
              </thead>
            </table>

          </div><!-- /checkedout -->


          <div class="tab-pane" id="files">

            <div class="row">
              <div class="col-md-12">
                <x-filestable
                        filepath="private_uploads/consumables/"
                        showfile_routename="show.consumablefile"
                        deletefile_routename="delete/consumablefile"
                        :object="$consumable" />

              </div>
            </div>

          </div><!--/FILES-->

          <div class="tab-pane" id="history">
            <div class="table-responsive">

              <table
                      class="table table-striped snipe-table"
                      id="consumableHistory"
                      data-pagination="true"
                      data-id-table="consumableHistory"
                      data-search="true"
                      data-side-pagination="server"
                      data-show-columns="true"
                      data-show-fullscreen="true"
                      data-show-refresh="true"
                      data-sort-order="desc"
                      data-sort-name="created_at"
                      data-show-export="true"
                      data-export-options='{
                         "fileName": "export-consumable-{{  $consumable->id }}-history",
                         "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                       }'

                      data-url="{{ route('api.activity.index', ['item_id' => $consumable->id, 'item_type' => 'consumable']) }}"
                      data-cookie-id-table="assetHistory"
                      data-cookie="true">
                <thead>
                <tr>
                  <th data-visible="true" data-field="icon" style="width: 40px;" class="hidden-xs" data-formatter="iconFormatter">{{ trans('admin/hardware/table.icon') }}</th>
                  <th data-visible="true" data-field="action_date" data-sortable="true" data-formatter="dateDisplayFormatter">{{ trans('general.date') }}</th>
                  <th data-visible="true" data-field="admin" data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                  <th data-visible="true" data-field="action_type">{{ trans('general.action') }}</th>
                  <th class="col-sm-2" data-field="file" data-visible="false" data-formatter="fileUploadNameFormatter">{{ trans('general.file_name') }}</th>
                  <th data-visible="true" data-field="item" data-formatter="polymorphicItemFormatter">{{ trans('general.item') }}</th>
                  <th data-visible="true" data-field="target" data-formatter="polymorphicItemFormatter">{{ trans('general.target') }}</th>
                  <th data-field="note">{{ trans('general.notes') }}</th>
                  <th data-field="signature_file" data-visible="false"  data-formatter="imageFormatter">{{ trans('general.signature') }}</th>
                  <th data-visible="false" data-field="file" data-visible="false"  data-formatter="fileUploadFormatter">{{ trans('general.download') }}</th>
                  <th data-field="log_meta" data-visible="true" data-formatter="changeLogFormatter">{{ trans('admin/hardware/table.changed')}}</th>
                  <th data-field="remote_ip" data-visible="false" data-sortable="true">{{ trans('admin/settings/general.login_ip') }}</th>
                  <th data-field="user_agent" data-visible="false" data-sortable="true">{{ trans('admin/settings/general.login_user_agent') }}</th>
                  <th data-field="action_source" data-visible="false" data-sortable="true">{{ trans('general.action_source') }}</th>
                </tr>
                </thead>
              </table>
            </div>
          </div><!-- /.tab-pane -->
      </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->
  </div>

  @can('update', \App\Models\User::class)
    @include ('modals.upload-file', ['item_type' => 'consumable', 'item_id' => $consumable->id])
  @endcan



@stop

@section('moar_scripts')

        <script>

          $('#dataConfirmModal').on('show.bs.modal', function (event) {
            var content = $(event.relatedTarget).data('content');
            var title = $(event.relatedTarget).data('title');
            $(this).find(".modal-body").text(content);
            $(this).find(".modal-header").text(title);
          });

        </script>


  @include ('partials.bootstrap-table', ['simple_view' => true])
@endsection