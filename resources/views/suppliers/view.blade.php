@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/suppliers/table.view') }} -
{{ $supplier->name }}
@parent
@stop

@section('header_right')
  <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-default pull-right">
  {{ trans('admin/suppliers/table.update') }}</a>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">



    <!-- start tables -->

    <div class="box box-default">
      @if ($supplier->id)
      <div class="box-header with-border">
        <div class="box-heading">
          <h3 class="box-title"> {{ trans('general.assets') }}
          </h3>
        </div>
      </div><!-- /.box-header -->
      @endif

      <div class="box-body">
        <!-- checked out suppliers table -->
        <br>
        <div class="table-responsive">
          <table class="display table table-hover">
            <thead>
              <tr role="row">
                <th class="col-md-3">Asset Tag</th>
                <th class="col-md-3"><span class="line"></span>Name</th>
                <th class="col-md-3"><span class="line"></span>User</th>
                <th class="col-md-2"><span class="line"></span>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($supplier->assets as $supplierassets)
              <tr>
                <td>
                  <a href="{{ route('hardware.show',  $supplierassets->id) }}">
                    {{ $supplierassets->asset_tag }}
                  </a>
                </td>
                <td>
                  <a href="{{ route('hardware.show',  $supplierassets->id) }}">
                    {{ $supplierassets->name }}
                  </a>
                </td>
                <td>
                  @if ($supplierassets->assignedTo)
                  {!! $supplierassets->assignedTo->present()->nameUrl() !!}
                  @endif
                </td>
                <td>
                  @if ($supplierassets->assigned_to != '')
                  <a href="{{ route('checkin/hardware', $supplierassets->id) }}" class="btn btn-info btn-sm">Checkin</a>
                  @else
                  <a href="{{ route('checkout/hardware', $supplierassets->id) }}" class="btn btn-success btn-sm">Checkout</a>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div> <!--/box-body-->
    </div>
  </div> <!--/col-md-9-->

  <!-- side address column -->
  <div class="col-md-3">
    <h4>Contact:</h4>
    <ul class="list-unstyled">
      @if ($supplier->contact)
      <li><i class="fa fa-user"></i>{{ $supplier->contact }}</li>
      @endif
      @if ($supplier->phone)
      <li><i class="fa fa-phone"></i>{{ $supplier->phone }}</li>
      @endif
      @if ($supplier->fax)
      <li><i class="fa fa-print"></i>{{ $supplier->fax }}</li>
      @endif

      @if ($supplier->email)
      <li>
        <i class="fa fa-envelope-o"></i>
        <a href="mailto:{{ $supplier->email }}">
        {{ $supplier->email }}
        </a>
      </li>
      @endif

      @if ($supplier->url)
      <li>
        <i class="fa fa-globe"></i>
        <a href="{{ $supplier->url }}" target="_new">{{ $supplier->url }}</a>
      </li>
      @endif

      @if ($supplier->address)
      <li><br>
        {{ $supplier->address }}

        @if ($supplier->address2)
        <br>
        {{ $supplier->address2 }}
        @endif
        @if (($supplier->city) || ($supplier->state))
        <br>
        {{ $supplier->city }} {{ strtoupper($supplier->state) }} {{ $supplier->zip }} {{ strtoupper($supplier->country) }}
        @endif
      </li>
      @endif

      @if ($supplier->notes)
      <li><i class="fa fa-comment"></i>{{ $supplier->notes }}</li>
      @endif

      @if ($supplier->image)
      <li><br /><img src="{{ url('/') }}/uploads/suppliers/{{ $supplier->image }}" /></li>
      @endif
    </ul>
  </div> <!--/col-md-3-->
</div> <!--/row-->

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">

      @if ($supplier->id)
      <div class="box-header with-border">
        <div class="box-heading">
          <h3 class="box-title">Software</h3>
        </div>
      </div><!-- /.box-header -->
      @endif

      <div class="box-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="col-md-4">Name</th>
              <th class="col-md-4"><span class="line"></span>Serial</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($supplier->licenses as $license)
            <tr>
              <td>{!! $license->present()->nameUrl() !!}</td>
              <td>{!! $license->present()->serialUrl() !!}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">

      @if ($supplier->id)
      <div class="box-header with-border">
        <div class="box-heading">
          <h3 class="box-title"> Improvements</h3>
        </div>
      </div><!-- /.box-header -->
      @endif

      <div class="box-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/table.asset_name') }}</th>
              <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}</th>
              <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/form.start_date') }}</th>
              <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/form.completion_date') }}</th>
              <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/table.is_warranty') }}</th>
              <th class="col-md-2"><span class="line"></span>{{ trans('admin/asset_maintenances/form.cost') }}</th>
              <th class="col-md-1"><span class="line"></span>{{ trans('table.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <?php $totalCost = 0; ?>
            @if ($supplier->asset_maintenances)
              @foreach ($supplier->asset_maintenances as $improvement)
                @if (is_null($improvement->deleted_at))
                <tr>
                  <td>
                    @if ($improvement->asset)
                      <a href="{{ route('hardware.show', $improvement->asset_id) }}">{{ $improvement->asset->name }}</a>
                    @else
                        (deleted asset)
                    @endif
                  </td>
                  <td>{{ $improvement->asset_maintenance_type }}</td>
                  <td>{{ $improvement->start_date }}</td>
                  <td>{{ $improvement->completion_date }}</td>
                  <td>{{ $improvement->is_warranty ? trans('admin/asset_maintenances/message.warranty') : trans('admin/asset_maintenances/message.not_warranty') }}</td>
                  <td>{{ sprintf( $snipeSettings->default_currency. '%01.2f', $improvement->cost) }}</td>
                    <?php $totalCost += $improvement->cost; ?>
                  <td><a href="{{ route('maintenances.edit', $improvement->id) }}" class="btn btn-warning"><i class="fa fa-pencil icon-white"></i></a>
                  </td>
                </tr>
                @endif
              @endforeach
            @endif
          </tbody>

          <tfoot>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>{{sprintf($snipeSettings->default_currency . '%01.2f', $totalCost)}}</td>
            </tr>
          </tfoot>
        </table>
      </div>

    </div>
  </div>
</div> <!-- /.row-->

@stop
